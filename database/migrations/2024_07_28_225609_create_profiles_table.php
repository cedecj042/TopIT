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
        Schema::create('students', function (Blueprint $table) {
            $table->id('student_id');
            $table->foreignId('user_id')->references('user_id')->on('users')->cascadeOnDelete();
            $table->string('firstname');
            $table->string('lastname');
            $table->float('theta_score');
            $table->string('profile_image');
            $table->date('birthdate');
            $table->integer('age');
            $table->string('address');
            $table->string('school');
            $table->integer('school_year');
            $table->timestamps();
        });
        Schema::create('coordinators', function (Blueprint $table) {
            $table->id('coordinator_id');
            $table->foreignId('user_id')->references('user_id')->on('users')->cascadeOnDelete();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('profile_image');
            $table->dateTime('last_login');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
        Schema::dropIfExists('coordinators');

    }
};
