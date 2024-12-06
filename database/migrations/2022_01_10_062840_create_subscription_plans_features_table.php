<?php

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
        Schema::create('subscription_plans_features', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subscription_plan_id')->nullable();
            $table->string('events');
            $table->string('schedule_events');
            $table->timestamps();

            $table->foreign('subscription_plan_id')->references('id')->on('subscription_plans')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_plans_features');
    }
};
