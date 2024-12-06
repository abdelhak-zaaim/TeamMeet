<?php

use App\Models\UserTransaction;
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
        Schema::table('user_transactions', function (Blueprint $table) {
            $table->integer('subscription_status')->default(UserTransaction::PENDING)->after('meta');
            $table->text('note')->nullable()->after('subscription_status');
            $table->string('transaction_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_transactions', function (Blueprint $table) {
            $table->dropColumn('subscription_status');
            $table->dropColumn('note');
        });
    }
};
