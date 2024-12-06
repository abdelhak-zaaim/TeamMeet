<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class DefaultCurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $inputs = [
            [
                'currency_name' => 'India Rupee',
                'currency_icon' => '₹',
                'currency_code' => 'INR',
                'is_default' => true,
            ],
            [
                'currency_name' => 'USA Dollar',
                'currency_icon' => '$',
                'currency_code' => 'USD',
                'is_default' => true,
            ],
            [
                'currency_name' => 'Australia Dollar',
                'currency_icon' => '$',
                'currency_code' => 'AUD',
                'is_default' => true,
            ],
            [
                'currency_name' => 'Japanese Yen',
                'currency_icon' => '¥',
                'currency_code' => 'JPY',
                'is_default' => true,
            ],
            [
                'currency_name' => 'British Pound',
                'currency_icon' => '£',
                'currency_code' => 'GBP',
                'is_default' => true,
            ],
            [
                'currency_name' => 'Canadian Dollar',
                'currency_icon' => '$',
                'currency_code' => 'CAD',
                'is_default' => true,
            ],
        ];

        $currencyCount = Currency::count();

        if ($currencyCount == 0) {
            foreach ($inputs as $input) {
                Currency::create($input);
            }
        }
    }
}
