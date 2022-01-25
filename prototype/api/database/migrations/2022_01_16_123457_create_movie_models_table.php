<?php

use Illuminate\Database\Migrations\Migration;
use Jenssegers\Mongodb\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovieModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('title');
            $table->integer('year');
            $table->string('image');
            $table->integer('duration');
            $table->text('plot');
            $table->text('directors');
            $table->text('stars');
            $table->text('genres');
            $table->string('country');
            $table->text('languages');
            $table->decimal('rating');
            $table->string('trailer');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movies');
    }
}
