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
        Schema::create('modules', function (Blueprint $table) {
            $table->id('module_id');
            $table->string('title');
            $table->json('content');
            $table->timestamps();
        });

        Schema::create('lessons',function(Blueprint $table){
            $table->id('lesson_id');
            $table->foreignId('module_id')->references('module_id')->on('modules')->cascadeOnDelete();
            $table->string('title');
            $table->json('content');
            $table->integer('order');
            $table->timestamps();
        });

        Schema::create('sections',function(Blueprint $table){
            $table->id('section_id');
            $table->foreignId('lesson_id')->references('lesson_id')->on('lessons')->cascadeOnDelete();
            $table->string('title');
            $table->json('content');
            $table->integer('order');
            $table->timestamps();
        });

        Schema::create('subsections',function(Blueprint $table){
            $table->id('subsection_id');
            $table->foreignId('section_id')->references('section_id')->on('sections')->cascadeOnDelete();
            $table->string('title');
            $table->json('content');
            $table->integer('order');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modules');
        Schema::dropIfExists('lessons');
        Schema::dropIfExists('sections');
        Schema::dropIfExists('subsection');
    }
};
