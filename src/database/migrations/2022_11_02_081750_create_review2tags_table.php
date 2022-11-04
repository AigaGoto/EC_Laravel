<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReview2TagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('review2tags', function (Blueprint $table) {
            $table->unsignedBigInteger('review_id')->commnet('レビューID');
            $table->unsignedBigInteger('tag_id')->commnet('タグID');
            $table->foreign('review_id')->references('review_id')->on('reviews')->onDelete('cascade');
            $table->foreign('tag_id')->references('tag_id')->on('tags')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('review2tags');
    }
}
