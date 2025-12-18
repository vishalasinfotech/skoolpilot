<?php

namespace App\Http\Middleware;

use App\Models\Transaction;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSchoolHasActiveSubscription
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        if (! $user->school_id) {
            return redirect()
                ->route('dashboard')
                ->with('error', 'School not found. Please contact administrator.');
        }

        $latestCompletedTransaction = Transaction::query()
            ->with('subscriptionPlan')
            ->where('school_id', $user->school_id)
            ->where('status', 'completed')
            ->orderByDesc('paid_at')
            ->orderByDesc('id')
            ->first();

        if (! $latestCompletedTransaction) {
            return redirect()
                ->route('subscription-plan.plans')
                ->with('error', 'Please purchase a subscription plan to access School Admin features.');
        }

        if ($latestCompletedTransaction->expires_at !== null && $latestCompletedTransaction->expires_at->isPast()) {
            return redirect()
                ->route('subscription-plan.plans')
                ->with('error', 'Your subscription has expired. Please renew your plan to continue.');
        }

        if ($latestCompletedTransaction->subscriptionPlan && ! $latestCompletedTransaction->subscriptionPlan->is_active) {
            return redirect()
                ->route('subscription-plan.plans')
                ->with('error', 'Your subscription plan is inactive. Please choose another plan to continue.');
        }

        return $next($request);
    }
}
