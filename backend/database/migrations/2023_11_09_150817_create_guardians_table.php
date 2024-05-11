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
        Schema::create('guardians', function (Blueprint $table) {
            $table->id();
            $table->string('profile', 500);
            $table->string('first_name', 500);
            $table->string('last_name', 500);
            $table->string('gender', 200);
            $table->date('date_of_birth', 500);
            $table->string('age', 100);
            $table->string('chatId');
            $table->string('phone_number', 24);
            $table->string('email', 255);
            $table->string('address', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guardians');
    }
};
