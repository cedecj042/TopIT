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
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id('user_profile_id');
            $table->foreignId('user_id')->references('user_id')->on('users')->cascadeOnDelete();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('profile_image');
            $table->date('birthdate');
            $table->integer('age');
            $table->string('address');
            $table->string('school');
            $table->year('year');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profile');
    }
};
