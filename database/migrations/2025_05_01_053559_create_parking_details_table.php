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
        Schema::create('parking_details', function (Blueprint $table) {
            $table->id('garage_id');
            $table->text('images')->nullable();
            $table->decimal('rent', 10, 2);
            $table->string('parking_type', 50);
            $table->string('area', 100);
            $table->string('division', 100);
            $table->text('location');
            $table->boolean('camera')->nullable();
            $table->boolean('guard')->nullable();
            $table->string('indoor', 20)->nullable();
            $table->unsignedBigInteger('usr_id')->nullable();
            $table->integer('bike_slot')->nullable();
            $table->integer('car_slot')->nullable();
            $table->integer('bicycle_slot')->nullable();
            $table->string('start_time', 10)->nullable();
            $table->string('end_time', 10)->nullable();
            $table->text('nid')->nullable();
            $table->text('utility_bill')->nullable();
            $table->text('passport')->nullable();
            $table->text('alt_name')->nullable();
            $table->text('alt_phone')->nullable();
            $table->string('payment_method', 50)->nullable();
            $table->string('bank_details', 255)->nullable();
            $table->timestamps();
            $table->foreign('usr_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parking_details');
    }
};
