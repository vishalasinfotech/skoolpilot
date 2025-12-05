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
            // Free Plan
            [
                'name' => 'Free Starter Plan',
                'description' => 'Perfect for trying out our platform. Get started with essential features at no cost.',
                'type' => 'lifetime',
                'tier' => 'basic',
                'plan_status' => 'free',
                'price' => 0.00,
                'offer_price' => null,
                'features' => [
                    'Up to 25 students',
                    'Basic attendance tracking',
                    'Email support',
                    '1GB storage',
                    'Limited features',
                ],
                'trial_days' => 0,
                'is_active' => true,
            ],

            // Basic Plans
            [
                'name' => 'Basic Monthly Plan',
                'description' => 'Ideal for small schools looking to manage up to 100 students efficiently.',
                'type' => 'monthly',
                'tier' => 'basic',
                'plan_status' => 'paid',
                'price' => 29.99,
                'offer_price' => null,
                'features' => [
                    'Up to 100 students',
                    'Basic attendance tracking',
                    'Email support',
                    'Monthly reports',
                    '5GB storage',
                ],
                'trial_days' => 15,
                'is_active' => true,
            ],
            [
                'name' => 'Basic Quarterly Plan',
                'description' => 'Save 10% with our quarterly plan. Best for schools planning ahead.',
                'type' => 'quarterly',
                'tier' => 'basic',
                'plan_status' => 'paid',
                'price' => 80.97,
                'offer_price' => 72.87,
                'features' => [
                    'Up to 100 students',
                    'Basic attendance tracking',
                    'Email support',
                    'Monthly reports',
                    '5GB storage',
                    '10% discount (3 months)',
                ],
                'trial_days' => 15,
                'is_active' => true,
            ],
            [
                'name' => 'Basic Yearly Plan',
                'description' => 'Maximum savings! Get 20% off with our annual subscription.',
                'type' => 'yearly',
                'tier' => 'basic',
                'plan_status' => 'paid',
                'price' => 287.90,
                'offer_price' => 230.32,
                'features' => [
                    'Up to 100 students',
                    'Basic attendance tracking',
                    'Email support',
                    'Monthly reports',
                    '5GB storage',
                    '20% discount (12 months)',
                ],
                'trial_days' => 30,
                'is_active' => true,
            ],

            // Standard Plans
            [
                'name' => 'Standard Monthly Plan',
                'description' => 'Most popular! Perfect for growing schools with advanced features and parent engagement tools.',
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
                'name' => 'Standard Quarterly Plan',
                'description' => 'Great value for medium-sized schools. Save 10% on our most popular tier.',
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
                'name' => 'Standard Yearly Plan',
                'description' => 'Best value! Unlock all standard features with maximum annual savings.',
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

            // Premium Plans
            [
                'name' => 'Premium Monthly Plan',
                'description' => 'Ultimate package for large institutions. Unlimited everything with priority support.',
                'type' => 'monthly',
                'tier' => 'premium',
                'plan_status' => 'paid',
                'price' => 99.99,
                'offer_price' => null,
                'features' => [
                    'Unlimited students',
                    'Advanced attendance & analytics',
                    '24/7 priority support',
                    'Real-time reports',
                    'Parent & student portals',
                    'SMS & email notifications',
                    'Custom branding',
                    'API access',
                    'Unlimited storage',
                    'Dedicated account manager',
                ],
                'trial_days' => 15,
                'is_active' => true,
            ],
            [
                'name' => 'Premium Quarterly Plan',
                'description' => 'Enterprise solution with quarterly savings. Perfect for schools requiring full customization.',
                'type' => 'quarterly',
                'tier' => 'premium',
                'plan_status' => 'paid',
                'price' => 269.97,
                'offer_price' => 242.97,
                'features' => [
                    'Unlimited students',
                    'Advanced attendance & analytics',
                    '24/7 priority support',
                    'Real-time reports',
                    'Parent & student portals',
                    'SMS & email notifications',
                    'Custom branding',
                    'API access',
                    'Unlimited storage',
                    'Dedicated account manager',
                    '10% discount (3 months)',
                ],
                'trial_days' => 15,
                'is_active' => true,
            ],
            [
                'name' => 'Premium Yearly Plan',
                'description' => 'The ultimate annual deal! Get all premium features with maximum savings and priority support.',
                'type' => 'yearly',
                'tier' => 'premium',
                'plan_status' => 'paid',
                'price' => 959.90,
                'offer_price' => 767.92,
                'features' => [
                    'Unlimited students',
                    'Advanced attendance & analytics',
                    '24/7 priority support',
                    'Real-time reports',
                    'Parent & student portals',
                    'SMS & email notifications',
                    'Custom branding',
                    'API access',
                    'Unlimited storage',
                    'Dedicated account manager',
                    '20% discount (12 months)',
                    'Priority feature requests',
                ],
                'trial_days' => 30,
                'is_active' => true,
            ],

            // Lifetime Premium Plan
            [
                'name' => 'Premium Lifetime Access',
                'description' => 'One-time payment, lifetime access! The best investment for your school. Never pay again!',
                'type' => 'lifetime',
                'tier' => 'premium',
                'plan_status' => 'paid',
                'price' => 2999.00,
                'offer_price' => 2499.00,
                'features' => [
                    'Unlimited students - Forever',
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
