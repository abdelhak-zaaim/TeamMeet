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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->boolean('status')->default(1);
            $table->string('language')->default('en')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('gender')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('domain_url')->nullable();
            $table->string('timezone')->nullable();
            $table->string('region_code')->nullable();
            $table->integer('step')->nullable();
            $table->unsignedInteger('personal_experience_id')->nullable();
            $table->foreign('personal_experience_id')->references('id')->on('personal_experiences')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
