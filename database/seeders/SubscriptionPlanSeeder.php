<?php

namespace Database\Seeders;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Free Plan',
                'description' => 'Start using basic features at no cost. Perfect for individuals or small schools just getting started.',
                'type' => 'monthly',
                'tier' => 'basic',
                'plan_status' => 'free',
                'price' => 0.00,
                'offer_price' => null,
                'features' => [
                    'Up to 50 students',
                    'Basic attendance tracking',
                    'Limited support (Email only)',
                    'Basic reports',
                    'Parent portal access',
                    '5GB storage',
                ],
                'trial_days' => 0,
                'is_active' => true,
            ],
            [
                'name' => 'Monthly Plan',
                'description' => 'Access all standard features with a monthly payment. Ideal for flexible budgeting.',
                'type' => 'monthly',
                'tier' => 'standard',
                'plan_status' => 'paid',
                'price' => 59.99,
                'offer_price' => null,
                'features' => [
                    'Up to 500 students',
                    'Advanced attendance tracking',
                    'Email & phone support',
                    'Weekly reports',
                    'Parent portal access',
                    'SMS notifications',
                    '25GB storage',
                ],
                'trial_days' => 15,
                'is_active' => true,
            ],
            [
                'name' => 'Quarterly Plan',
                'description' => 'Save money by subscribing every three months. Great value for small to medium-sized institutions.',
                'type' => 'quarterly',
                'tier' => 'standard',
                'plan_status' => 'paid',
                'price' => 161.97,
                'offer_price' => 145.77,
                'features' => [
                    'Up to 500 students',
                    'Advanced attendance tracking',
                    'Email & phone support',
                    'Weekly reports',
                    'Parent portal access',
                    'SMS notifications',
                    '25GB storage',
                    '10% discount (3 months)',
                ],
                'trial_days' => 15,
                'is_active' => true,
            ],
            [
                'name' => 'Yearly Plan',
                'description' => 'Get even greater savings with an annual subscription. Perfect for established schools.',
                'type' => 'yearly',
                'tier' => 'standard',
                'plan_status' => 'paid',
                'price' => 575.90,
                'offer_price' => 460.72,
                'features' => [
                    'Up to 500 students',
                    'Advanced attendance tracking',
                    'Email & phone support',
                    'Weekly reports',
                    'Parent portal access',
                    'SMS notifications',
                    '25GB storage',
                    '20% discount (12 months)',
                ],
                'trial_days' => 30,
                'is_active' => true,
            ],
            [
                'name' => 'Lifetime Plan',
                'description' => 'One-time payment for lifetime access to all features. Never worry about renewal again!',
                'type' => 'lifetime',
                'tier' => 'premium',
                'plan_status' => 'paid',
                'price' => 2999.00,
                'offer_price' => 2499.00,
                'features' => [
                    'Unlimited students',
                    'All premium features - Lifetime',
                    '24/7 priority support',
                    'Real-time reports & analytics',
                    'Parent & student portals',
                    'SMS & email notifications',
                    'Custom branding',
                    'API access',
                    'Unlimited storage',
                    'Dedicated account manager',
                    'Priority feature requests',
                    'Free future updates',
                    'One-time payment only',
                ],
                'trial_days' => 30,
                'is_active' => true,
            ],
        ];

        foreach ($plans as $plan) {
            SubscriptionPlan::create($plan);
        }
    }
}
