<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\SubscriptionPlan;
use App\Models\Transaction;
use App\Services\RazorpayService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class PaymentController extends Controller
{
    protected RazorpayService $razorpayService;

    public function __construct(RazorpayService $razorpayService)
    {
        $this->razorpayService = $razorpayService;
    }

    /**
     * Show checkout page for a subscription plan
     */
    public function checkout(SubscriptionPlan $plan): View|RedirectResponse
    {
        // Check if user is authenticated and has a school
        if (! Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to purchase a plan.');
        }

        $user = Auth::user();
        $school = School::find($user->school_id);

        if (! $school) {
            return redirect()->route('dashboard')->with('error', 'School not found. Please contact administrator.');
        }

        // If plan is free, directly assign it
        if ($plan->plan_status === 'free' || $plan->price == 0) {
            return $this->handleFreePlan($school, $plan);
        }

        // Calculate amount (use offer price if available)
        $amount = $plan->offer_price ?? $plan->price;

        return view('payment.checkout', compact('plan', 'school', 'amount'));
    }

    /**
     * Create Razorpay order and initiate payment
     */
    public function createOrder(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'plan_id' => ['required', 'exists:subscription_plans,id'],
        ]);

        $plan = SubscriptionPlan::findOrFail($request->plan_id);
        $user = Auth::user();
        $school = School::findOrFail($user->school_id);

        // Calculate amount
        $amount = $plan->offer_price ?? $plan->price;

        // Create transaction record
        $transaction = Transaction::create([
            'school_id' => $school->id,
            'subscription_plan_id' => $plan->id,
            'amount' => $amount,
            'currency' => 'INR',
            'status' => 'pending',
            'payment_method' => 'razorpay',
        ]);

        // Create Razorpay order
        $orderData = [
            'receipt' => 'txn_'.$transaction->id,
            'amount' => $amount,
            'currency' => 'INR',
            'notes' => [
                'school_id' => $school->id,
                'plan_id' => $plan->id,
                'transaction_id' => $transaction->id,
            ],
        ];

        $razorpayOrder = $this->razorpayService->createOrder($orderData);

        if (! $razorpayOrder['success']) {
            $transaction->update([
                'status' => 'failed',
                'failure_reason' => $razorpayOrder['message'] ?? 'Order creation failed',
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to create payment order. Please try again.',
            ], 500);
        }

        // Update transaction with Razorpay order ID
        $transaction->update([
            'razorpay_order_id' => $razorpayOrder['order_id'],
        ]);

        return response()->json([
            'success' => true,
            'order_id' => $razorpayOrder['order_id'],
            'amount' => $razorpayOrder['amount'],
            'currency' => $razorpayOrder['currency'],
            'key_id' => config('services.razorpay.key_id'),
            'transaction_id' => $transaction->id,
        ]);
    }

    /**
     * Handle payment success callback
     */
    public function success(Request $request): RedirectResponse
    {
        $request->validate([
            'razorpay_order_id' => ['required', 'string'],
            'razorpay_payment_id' => ['required', 'string'],
            'razorpay_signature' => ['required', 'string'],
            'transaction_id' => ['required', 'exists:transactions,id'],
        ]);

        $transaction = Transaction::findOrFail($request->transaction_id);

        // Verify payment signature
        $isValid = $this->razorpayService->verifyPayment([
            'razorpay_order_id' => $request->razorpay_order_id,
            'razorpay_payment_id' => $request->razorpay_payment_id,
            'razorpay_signature' => $request->razorpay_signature,
        ]);

        if (! $isValid) {
            $transaction->update([
                'status' => 'failed',
                'failure_reason' => 'Payment signature verification failed',
            ]);

            return redirect()->route('payment.failed-page')
                ->with('error', 'Payment verification failed. Please contact support.');
        }

        // Update transaction
        DB::beginTransaction();
        try {
            $school = $transaction->school;
            $plan = $transaction->subscriptionPlan;

            // Calculate expires_at: now + trial_days from subscription_plans table
            $expiresAt = null;
            if ($plan->trial_days > 0) {
                $expiresAt = now()->addDays($plan->trial_days);
            }

            $transaction->update([
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature,
                'status' => 'completed',
                'paid_at' => now(),
                'expires_at' => $expiresAt,
                'payment_details' => [
                    'order_id' => $request->razorpay_order_id,
                    'payment_id' => $request->razorpay_payment_id,
                ],
            ]);

            // Update school subscription
            $school->update([
                'subscription_plan_id' => $plan->id,
                'status' => true,
            ]);

            // Set trial end date if applicable
            if ($plan->trial_days > 0) {
                $school->update([
                    'trial_ends_at' => now()->addDays($plan->trial_days),
                ]);
            }

            DB::commit();

            return redirect()->route('payment.success-page')
                ->with('success', 'Payment successful! Your subscription has been activated.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payment Success Handler Error: '.$e->getMessage());

            $transaction->update([
                'status' => 'failed',
                'failure_reason' => 'Error processing payment: '.$e->getMessage(),
            ]);

            return redirect()->route('payment.failed-page')
                ->with('error', 'Payment processed but subscription activation failed. Please contact support.');
        }
    }

    /**
     * Handle payment failure callback
     */
    public function failed(Request $request): RedirectResponse
    {
        if ($request->has('transaction_id')) {
            $transaction = Transaction::find($request->transaction_id);
            if ($transaction && $transaction->status === 'pending') {
                $transaction->update([
                    'status' => 'failed',
                    'failure_reason' => $request->get('error_description', 'Payment failed'),
                ]);
            }
        }

        return redirect()->route('subscription-plan.plans')
            ->with('error', 'Payment failed. Please try again.');
    }

    /**
     * Handle free plan assignment
     */
    protected function handleFreePlan(School $school, SubscriptionPlan $plan): RedirectResponse
    {
        DB::beginTransaction();
        try {
            // Calculate expires_at: now + trial_days from subscription_plans table
            $expiresAt = null;
            if ($plan->trial_days > 0) {
                $expiresAt = now()->addDays($plan->trial_days);
            }

            // Create transaction record for free plan
            Transaction::create([
                'school_id' => $school->id,
                'subscription_plan_id' => $plan->id,
                'amount' => 0,
                'currency' => 'INR',
                'status' => 'completed',
                'payment_method' => 'other',
                'paid_at' => now(),
                'expires_at' => $expiresAt,
            ]);

            // Update school subscription
            $school->update([
                'subscription_plan_id' => $plan->id,
                'status' => true,
            ]);

            if ($plan->trial_days > 0) {
                $school->update([
                    'trial_ends_at' => now()->addDays($plan->trial_days),
                ]);
            }

            DB::commit();

            return redirect()->route('payment.success-page')
                ->with('success', 'Free plan activated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Free Plan Activation Error: '.$e->getMessage());

            return redirect()->route('subscription-plan.plans')
                ->with('error', 'Failed to activate free plan. Please try again.');
        }
    }

    /**
     * Show payment success page
     */
    public function successPage(): View
    {
        return view('payment.success');
    }

    /**
     * Show payment failed page
     */
    public function failedPage(): View
    {
        return view('payment.failed');
    }

    /**
     * Show transaction history
     */
    public function transactionHistory(): View
    {
        return view('payment.transaction-history');
    }

    /**
     * Show transaction details and invoice
     */
    public function show(Transaction $transaction): View
    {
        $transaction->load(['school', 'subscriptionPlan']);

        return view('payment.invoice', compact('transaction'));
    }
}
