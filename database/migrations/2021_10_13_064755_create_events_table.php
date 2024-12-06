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
        Schema::create('events', function (Blueprint $table) {
            $table->id('id');
            $table->string('name');
            $table->unsignedInteger('event_location');
            $table->text('description')->nullable();
            $table->string('event_link', 160)->nullable();
            $table->string('event_color', 160)->nullable();
            $table->json('location_meta')->nullable();
            $table->unsignedBigInteger('schedule_id')->nullable();
            $table->foreignId('user_id')->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('slot_time', 160)->default('30');
            $table->string('gap_slot', 160)->nullable();
            $table->string('max_event_per_day', 160)->nullable();
            $table->boolean('secret_event')->default(false);
            $table->string('schedule_days', 160)->default('60');
            $table->string('schedule_from', 160)->nullable();
            $table->string('schedule_to', 160)->nullable();
            $table->boolean('date_range')->default(true);
            $table->boolean('status')->default(true);
            $table->unsignedInteger('event_type')->nullable();
            $table->double('payable_amount')->nullable();
            $table->timestamps();

            $table->foreign('schedule_id')->references('id')->on('schedules')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('events');
    }
};
