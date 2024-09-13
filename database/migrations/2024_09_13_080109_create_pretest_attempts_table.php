<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePretestAttemptsTable extends Migration
{
    public function up()
    {
        Schema::create('pretest_attempts', function (Blueprint $table) {
            $table->id('pretest_id'); 
            $table->foreignId('student_id') 
                  ->constrained('students', 'student_id') 
                  ->onDelete('cascade'); 
            $table->json('answers'); 
            $table->integer('score');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pretest_attempts');
    }
}
