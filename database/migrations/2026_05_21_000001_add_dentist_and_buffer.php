<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add buffer_minutes to services
        Schema::table('services', function (Blueprint $table) {
            $table->integer('buffer_minutes')->default(10)->after('duration_minutes');
        });

        // Add dentist_id to appointments
        Schema::table('appointments', function (Blueprint $table) {
            $table->foreignId('dentist_id')->nullable()->constrained('users')->after('service_id');
            $table->time('end_time')->nullable()->after('appointment_time');
            $table->boolean('is_online_booking')->default(true)->after('notes');
        });

        // Update users table to add role 'dentist'
        Schema::table('users', function (Blueprint $table) {
            $table->time('working_start')->nullable()->after('role');
            $table->time('working_end')->nullable()->after('working_start');
            $table->json('unavailable_dates')->nullable()->after('working_end');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['working_start', 'working_end', 'unavailable_dates']);
        });

        Schema::table('appointments', function (Blueprint $table) {
            $table->dropForeign(['dentist_id']);
            $table->dropColumn(['dentist_id', 'end_time', 'is_online_booking']);
        });

        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('buffer_minutes');
        });
    }
};