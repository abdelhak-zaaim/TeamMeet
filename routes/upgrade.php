<?php

// upgrade to v1.1.0
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/upgrade-to-v1-1-0', function () {
    Artisan::call('migrate',
        [
            '--force' => true,
            '--path' => 'database/migrations/2022_02_01_140622_create_user_settings_table.php',
        ]);
    Artisan::call('migrate',
        [
            '--force' => true,
            '--path' => 'database/migrations/2022_02_07_123050_change_field_nullable_in_settings_table.php',
        ]);
    Artisan::call('db:seed', ['--class' => 'AddDefaultFieldInSetting', '--force' => true]);
});

// upgrade to v2.2.0
Route::get('/upgrade-to-v2-2-0', function () {
    Artisan::call('migrate',
        [
            '--force' => true,
            '--path' => 'database/migrations/2022_05_10_123950_create_google_calendar_lists_table.php',
        ]);
    Artisan::call('migrate',
        [
            '--force' => true,
            '--path' => 'database/migrations/2022_05_10_124139_create_google_calendar_integrations_table.php',
        ]);
    Artisan::call('migrate',
        [
            '--force' => true,
            '--path' => 'database/migrations/2022_05_11_114825_create_event_google_calendars_table.php',
        ]);
    Artisan::call('migrate',
        [
            '--force' => true,
            '--path' => 'database/migrations/2022_05_12_084217_create_user_google_event_schedules.php',
        ]);
    Artisan::call('migrate',
        [
            '--force' => true,
            '--path' => 'database/migrations/2022_05_13_094146_change_location_meta_field_type_in_events_table.php',
        ]);
});

// upgrade to v3.0.0
Route::get('/upgrade-to-v3-0-0', function () {
    Artisan::call('migrate',
        [
            '--force' => true,
            '--path' => 'database/migrations/2022_07_07_105940_change_question_field_type_in_faqs_table.php',
        ]);
});

// upgrade to v3.1.0
Route::get('/upgrade-to-v3-1-0', function () {
    Artisan::call('migrate',
        [
            '--force' => true,
            '--path' => 'database/migrations/2022_07_21_132820_change_access_token_field_type_in_google_calendar_integrations_table.php',
        ]);
});

Route::get('upgrade/database', function () {
    Artisan::call('migrate', ['--force' => true]);
});
