<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('tables', function (Blueprint $table) {
        $table->id('table_id');
        $table->unsignedBigInteger('tableable_id')->nullable();
        $table->string('tableable_type')->nullable();
        $table->json('content');
        $table->string('caption')->nullable();
        $table->timestamps();
    });

    Schema::create('figures', function (Blueprint $table) {
        $table->id('figure_id');
        $table->unsignedBigInteger('figureable_id')->nullable();
        $table->string('figureable_type')->nullable();
        $table->string('description')->nullable();
        $table->json('metadata')->nullable();
        $table->string('caption')->nullable();
        $table->timestamps();
    });

    Schema::create('codes', function (Blueprint $table) {
        $table->id('code_id');
        $table->unsignedBigInteger('codeable_id')->nullable();
        $table->string('codeable_type')->nullable();
        $table->string('description')->nullable();
        $table->json('metadata')->nullable();
        $table->string('caption')->nullable();
        $table->timestamps();
    });

    Schema::create('images', function (Blueprint $table) {
        $table->id('image_id');
        $table->unsignedBigInteger('imageable_id')->nullable();
        $table->string('imageable_type')->nullable();
        $table->string('file_name');
        $table->string('file_path');
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('tables');
        Schema::dropIfExists('figures');
        Schema::dropIfExists('codes');
        Schema::dropIfExists('images');
    }
};