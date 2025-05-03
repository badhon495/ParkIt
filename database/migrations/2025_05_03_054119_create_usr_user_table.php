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
        Schema::create('usr_user', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('name');
            $table->string('type', 10);
            $table->string('password');
            $table->string('email')->unique();
            $table->string('phone');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('usr_user');
    }
};
