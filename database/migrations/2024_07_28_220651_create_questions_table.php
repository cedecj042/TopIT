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
        Schema::create('question_category',function(Blueprint $table){
            $table->id('question_category_id');
            $table->string('name');
        });

        Schema::create('question_types',function(Blueprint $table){
            $table->id('question_type_id');
            $table->string('name');
        });
        Schema::create('options',function (Blueprint $table){
            $table->id('option_id');
            $table->string('content');
            $table->string('explanation');
        });
        Schema::create('questions', function (Blueprint $table) {
            $table->id('question_id');
            $table->foreignID('section_id')->references('section_id')->on('sections')->cascadeOnDelete();
            $table->foreignId('subsection_id')->references('subsection_id')->on('subsections')->cascadeOnDelete();
            $table->foreignId('question_type_id')->references('question_type_id')->on('question_types')->cascadeOnDelete();
            $table->foreignId('question_category_id')->references('question_category_id')->on('question_category')->cascadeOnDelete();
            $table->float('difficulty_numeric');
            $table->string('difficulty_level');
            $table->json('content');
            $table->float('discrimination_index');
            $table->float('guess_factor');
            $table->timestamps();
        });

        Schema::create('items',function (Blueprint $table){
            $table->id('item_id');
            $table->foreignId('question_id')->references('question_id')->on('questions')->cascadeOnDelete();
            $table->foreignId('option_id')->references('option_id')->on('options')->cascadeOnDelete();
            $table->boolean('is_correct');
            $table->integer('order');
            $table->float('selection_frequency');
            $table->float('point_biserial_correlation');
        });
        Schema::create('test_items', function (Blueprint $table) {
            $table->id('test_item_id');
            $table->foreignId('test_id')->references('test_id')->on('tests')->cascadeOnDelete();
            $table->foreignId('item_id')->references('item_id')->on('items')->cascadeOnDelete();
            $table->string('user_answer');
            $table->boolean('is_correct');
            $table->integer('order');
            $table->time('response_time');
            $table->timestamps();
        });



    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
        Schema::dropIfExists('responses');
        Schema::dropIfExists('options');
        Schema::dropIfExists('question_options');
        Schema::dropIfExists('question_category');
        Schema::dropIfExists('question_types');
    }
};
