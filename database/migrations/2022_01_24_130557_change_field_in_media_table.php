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
        Schema::table('media', function (Blueprint $table) {
            $table->string('model_type', 160)->change();
            $table->longText('manipulations')->change();
            $table->longText('custom_properties')->change();
            $table->longText('generated_conversions')->change();
            $table->longText('responsive_images')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('media', function (Blueprint $table) {
            //
        });
    }
};
