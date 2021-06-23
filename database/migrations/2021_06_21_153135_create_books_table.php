<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Название');
            $table->foreignId('authorId')->comment('Автор')->constrained('authors')->onDelete('cascade');
            $table->float('rating')->default(0)->comment('Рейтинг');
            $table->integer('countRating')->default(0)->comment('Количество рейтингов');
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
        Schema::dropIfExists('books');
    }
}
