<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public $withinTransaction = false;
    
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('parking_details', function (Blueprint $table) {
            $table->text('nid_photo_url')->nullable();
            $table->text('bill_photo_url')->nullable();
            $table->text('passport_photo_url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('parking_details', function (Blueprint $table) {
            $table->dropColumn(['nid_photo_url', 'bill_photo_url', 'passport_photo_url']);
        });
    }
};
