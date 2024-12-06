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
        Schema::table('user_schedules', function (Blueprint $table) {
            $table->boolean('check_tab')->after('day_of_week')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_schedules', function (Blueprint $table) {
            $table->dropColumn('check_tab');
        });
    }
};
