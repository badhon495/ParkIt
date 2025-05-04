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
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['start_time', 'end_time']);
            if (!Schema::hasColumn('bookings', 'booking_date')) {
                $table->date('booking_date')->nullable(false)->after('trxn');
            }
            if (!Schema::hasColumn('bookings', 'booked_slots')) {
                $table->json('booked_slots')->after('vehicle_details')->nullable(false);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (Schema::hasColumn('bookings', 'booked_slots')) {
                $table->dropColumn('booked_slots');
            }
            if (!Schema::hasColumn('bookings', 'start_time')) {
                $table->string('start_time')->nullable();
            }
            if (!Schema::hasColumn('bookings', 'end_time')) {
                $table->string('end_time')->nullable();
            }
            // Do not drop booking_date here
        });
    }
};
