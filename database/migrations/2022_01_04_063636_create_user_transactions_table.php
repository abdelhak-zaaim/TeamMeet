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
        Schema::create('user_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id');
            $table->integer('payment_type')->comment('1 = Stripe, 2 = Paypal');
            $table->float('amount');
            $table->unsignedBigInteger('user_id');
            $table->string('status');
            $table->text('meta')->nullable();

            $table->index('transaction_id');
            $table->index('payment_type');
            $table->index('amount');
            $table->index('user_id');
            $table->index('status');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_transactions');
    }
};
