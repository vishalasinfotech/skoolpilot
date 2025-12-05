<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SubscriptionPlan>
 */
class SubscriptionPlanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['monthly', 'quarterly', 'yearly'];
        $tiers = ['basic', 'standard', 'premium'];
        $type = fake()->randomElement($types);
        $tier = fake()->randomElement($tiers);

        $basePrice = match ($tier) {
            'basic' => 29.99,
            'standard' => 59.99,
            'premium' => 99.99,
        };

        $price = match ($type) {
            'monthly' => $basePrice,
            'quarterly' => $basePrice * 3 * 0.9, // 10% discount
            'yearly' => $basePrice * 12 * 0.8, // 20% discount
        };

        $features = match ($tier) {
            'basic' => [
                'Up to 100 students',
                'Basic attendance tracking',
                'Email support',
                'Monthly reports',
            ],
            'standard' => [
                'Up to 500 students',
                'Advanced attendance tracking',
                'Email & phone support',
                'Weekly reports',
                'Parent portal access',
                'SMS notifications',
            ],
            'premium' => [
                'Unlimited students',
                'Advanced attendance & analytics',
                '24/7 priority support',
                'Real-time reports',
                'Parent & student portals',
                'SMS & email notifications',
                'Custom branding',
                'API access',
            ],
        };

        return [
            'name' => ucfirst($tier).' '.ucfirst($type).' Plan',
            'type' => $type,
            'tier' => $tier,
            'price' => round($price, 2),
            'features' => $features,
            'trial_days' => fake()->randomElement([7, 14, 15, 30]),
            'is_active' => fake()->boolean(90), // 90% chance of being active
        ];
    }
}
