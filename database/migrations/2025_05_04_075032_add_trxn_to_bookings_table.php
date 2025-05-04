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
            $table->string('trxn')->nullable()->after('total_cost');
        });
    }
    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('trxn');
        });
    }
};
