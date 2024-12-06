<?php

namespace Database\Seeders;

use App\Models\PlanFeature;
use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;

class DefaultSubscriptionPlanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $inputs = [
            [
                'name' => 'Standard',
                'currency' => 'usd',
                'price' => 99,
                'frequency' => SubscriptionPlan::MONTH,
                'is_default' => 1,
                'trial_days' => 7,
            ],
            [
                'name' => 'Basic',
                'currency' => 'usd',
                'price' => 999,
                'frequency' => SubscriptionPlan::YEAR,
                'trial_days' => 30,
            ],
        ];

        foreach ($inputs as $input) {
            $subscriptionPlan = SubscriptionPlan::create($input);
            PlanFeature::create([
                'subscription_plan_id' => $subscriptionPlan->id, 'events' => 1, 'schedule_events' => 2,
            ]);
        }
    }
}
