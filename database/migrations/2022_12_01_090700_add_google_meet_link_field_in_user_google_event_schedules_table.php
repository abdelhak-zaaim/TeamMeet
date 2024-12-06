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
        Schema::table('user_google_event_schedules', function (Blueprint $table) {
            $table->string('google_meet_link')->nullable()->after('google_event_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_google_event_schedules', function (Blueprint $table) {
            $table->dropColumn('google_meet_link');
        });
    }
};
