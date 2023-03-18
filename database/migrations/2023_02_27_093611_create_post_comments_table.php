<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_comments', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned()->from(101);
            $table->bigInteger('postId')->unsigned()->nullable();
            $table->bigInteger('parentId')->nullable();
            $table->string('title', 100);
            $table->tinyText('published', 1)->default(0);
            $table->text('content')->nullable();
            $table->timestamps();

            $table->foreign('postId')->references('id')->on('posts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_comments');
    }
}
