<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned()->from(10010);
            $table->bigInteger('authorId')->unsigned();
            $table->bigInteger('parentId')->nullable();
            $table->string('title', 80);
            $table->string('slug', 100);
            $table->string('metaTitle', 100)->nullable();
            $table->tinyText('summary')->nullable();
            $table->tinyInteger('published')->default(0);
            $table->dateTime('publishedAt')->nullable();
            $table->text('content')->nullable();
            $table->timestamps();

            $table->foreign('authorId')->references('id')->on('authors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
