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
        Schema::create('user_schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('schedule_id')->nullable();
            $table->unsignedBigInteger('event_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->string('from_time')->nullable();
            $table->string('to_time')->nullable();
            $table->integer('day_of_week')->nullable();
            $table->timestamps();

            $table->foreign('schedule_id')->references('id')->on('schedules')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('event_id')->references('id')->on('events')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_schedules');
    }
};
