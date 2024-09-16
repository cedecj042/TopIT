<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('multichoice_many', function (Blueprint $table) {
            $table->renameColumn('answers', 'answer');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('multichoice_many', function (Blueprint $table) {
            $table->renameColumn('answer', 'answers');
        });
    }
};
