<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            // Add index to speed up overlap queries in AvailabilityChecker
            // Note: Unique constraint was skipped because existing data has duplicates.
            // Double-booking prevention is handled at application level via
            // AvailabilityChecker::checkOverlap() and NoDoubleBooking rule.
            $table->index(['dentist_id', 'appointment_date', 'status'], 'idx_dentist_date_status');
            $table->index(['appointment_date', 'appointment_time', 'end_time'], 'idx_appointment_datetime');
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropIndex('idx_dentist_date_status');
            $table->dropIndex('idx_appointment_datetime');
        });
    }
};