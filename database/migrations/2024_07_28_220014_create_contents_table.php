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
            $table->morphs('tableable');
            $table->json('content');
            $table->string('caption');
            $table->string('image_path');
            $table->timestamps();
        });

        Schema::create('figures', function (Blueprint $table) {
            $table->id('figure_id');
            $table->morphs('figureable');
            $table->string('description');
            $table->json('metadata');
            $table->string('caption');
            $table->string('image_path');
            $table->timestamps();
        });

        Schema::create('codes', function (Blueprint $table) {
            $table->id('code_id');
            $table->morphs('codeable');
            $table->string('description');
            $table->json('metadata');
            $table->string('caption');
            $table->string('image_path');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tables');
        Schema::dropIfExists('figures');
        Schema::dropIfExists('codes');
    }
};