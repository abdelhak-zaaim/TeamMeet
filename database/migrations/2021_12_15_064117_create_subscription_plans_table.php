<?php

use App\Models\SubscriptionPlan;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('currency')->nullable()->default('usd');
            $table->string('name');
            $table->float('price')->nullable()->default(0);
            $table->integer('frequency')->default(SubscriptionPlan::MONTH)->comment('1 = Month, 2 = Year');
            $table->boolean('is_default')->default(false);
            $table->integer('trial_days')->default(0)->comment('Default validity will be '.SubscriptionPlan::TRAIL_DAYS.' trial days');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('subscription_plans');
    }
};
