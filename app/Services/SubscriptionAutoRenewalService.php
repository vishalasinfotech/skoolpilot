<?php

namespace App\Services;

use App\Models\School;
use App\Models\Setting;
use App\Models\SubscriptionPlan;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SubscriptionAutoRenewalService
{
    protected RazorpayService $razorpayService;

    public function __construct(RazorpayService $razorpayService)
    {
        $this->razorpayService = $razorpayService;
    }

    /**
     * Check if auto-renewal is enabled for a school.
     */
    public function isAutoRenewalEnabled(int $schoolId): bool
    {
        return filter_var(
            Setting::get('subscription_auto_renewal', false, $schoolId),
            FILTER_VALIDATE_BOOLEAN
        );
    }

    /**
     * Get subscriptions that are expiring soon and need renewal.
     */
    public function getSubscriptionsExpiringSoon(int $daysBeforeExpiry = 7): \Illuminate\Database\Eloquent\Collection
    {
        $expiryDate = now()->addDays($daysBeforeExpiry);

        return Transaction::query()
            ->with(['school', 'subscriptionPlan'])
            ->where('status', 'completed')
            ->whereNotNull('expires_at') // Exclude lifetime plans (expires_at is null)
            ->where('expires_at', '<=', $expiryDate)
            ->where('expires_at', '>', now())
            ->whereHas('school', function ($query) {
                $query->where('status', true);
            })
            ->whereHas('subscriptionPlan', function ($query) {
                // Exclude lifetime plans
                $query->where('type', '!=', 'lifetime');
            })
            ->get()
            ->filter(function ($transaction) {
                // Only include if auto-renewal is enabled for this school
                return $this->isAutoRenewalEnabled($transaction->school_id);
            })
            ->unique('school_id'); // Only one transaction per school
    }

    /**
     * Process auto-renewal for a transaction.
     */
    public function processRenewal(Transaction $transaction): bool
    {
        $school = $transaction->school;
        $plan = $transaction->subscriptionPlan;

        if (! $school || ! $plan) {
            Log::warning("Auto-renewal failed: School or plan not found for transaction {$transaction->id}");

            return false;
        }

        // Skip if plan is free or lifetime
        if ($plan->plan_status === 'free' || $plan->type === 'lifetime' || $plan->price == 0) {
            Log::info("Auto-renewal skipped: Plan {$plan->id} is free or lifetime");

            return false;
        }

        // Check if auto-renewal is enabled
        if (! $this->isAutoRenewalEnabled($school->id)) {
            Log::info("Auto-renewal skipped: Auto-renewal is disabled for school {$school->id}");

            return false;
        }

        DB::beginTransaction();
        try {
            // Calculate new expiry date based on plan type
            $newExpiresAt = $this->calculateNewExpiryDate($plan, $transaction->expires_at);

            // Create new transaction for renewal
            $renewalTransaction = Transaction::create([
                'school_id' => $school->id,
                'subscription_plan_id' => $plan->id,
                'amount' => $plan->offer_price ?? $plan->price,
                'currency' => 'INR',
                'status' => 'pending',
                'payment_method' => 'razorpay',
                'payment_details' => [
                    'auto_renewal' => true,
                    'previous_transaction_id' => $transaction->id,
                ],
            ]);

            // Create Razorpay order for renewal
            $orderData = [
                'receipt' => 'renewal_'.$renewalTransaction->id,
                'amount' => $renewalTransaction->amount,
                'currency' => 'INR',
                'notes' => [
                    'school_id' => $school->id,
                    'plan_id' => $plan->id,
                    'transaction_id' => $renewalTransaction->id,
                    'auto_renewal' => true,
                ],
            ];

            $razorpayOrder = $this->razorpayService->createOrder($orderData);

            if (! $razorpayOrder['success']) {
                $renewalTransaction->update([
                    'status' => 'failed',
                    'failure_reason' => $razorpayOrder['message'] ?? 'Order creation failed',
                ]);

                DB::rollBack();
                Log::error("Auto-renewal failed: Could not create Razorpay order for transaction {$renewalTransaction->id}");

                return false;
            }

            // Update transaction with Razorpay order ID
            $renewalTransaction->update([
                'razorpay_order_id' => $razorpayOrder['order_id'],
            ]);

            // For now, we'll mark it as pending. In a real scenario, you might want to:
            // 1. Use Razorpay subscriptions API for automatic recurring payments
            // 2. Or process the payment immediately if you have stored payment methods
            // 3. Or send a notification to the school admin to complete the payment

            DB::commit();
            Log::info("Auto-renewal initiated: Transaction {$renewalTransaction->id} created for school {$school->id}");

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Auto-renewal error: {$e->getMessage()} for transaction {$transaction->id}");

            return false;
        }
    }

    /**
     * Calculate new expiry date based on plan type.
     */
    protected function calculateNewExpiryDate(SubscriptionPlan $plan, ?\Carbon\Carbon $currentExpiresAt): ?\Carbon\Carbon
    {
        $baseDate = $currentExpiresAt ?? now();

        return match ($plan->type) {
            'monthly' => $baseDate->copy()->addMonth(),
            'quarterly' => $baseDate->copy()->addMonths(3),
            'yearly' => $baseDate->copy()->addYear(),
            'lifetime' => null,
            default => $baseDate->copy()->addMonth(),
        };
    }

    /**
     * Process all pending auto-renewals.
     */
    public function processPendingRenewals(): array
    {
        $expiringTransactions = $this->getSubscriptionsExpiringSoon();
        $results = [
            'processed' => 0,
            'succeeded' => 0,
            'failed' => 0,
        ];

        foreach ($expiringTransactions as $transaction) {
            $results['processed']++;
            if ($this->processRenewal($transaction)) {
                $results['succeeded']++;
            } else {
                $results['failed']++;
            }
        }

        return $results;
    }
}
