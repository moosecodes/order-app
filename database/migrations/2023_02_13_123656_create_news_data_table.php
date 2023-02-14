<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_data_articles', function (Blueprint $table) {
            $table->id();
            $table->integer('favs')->default(0);
            $table->integer('views')->default(0);
            $table->string('api_source')->nullable();
            $table->string('title')->nullable();
            $table->string('link')->nullable();
            $table->string('keywords')->nullable();
            $table->string('creator')->nullable();
            $table->string('video_url')->nullable();
            $table->string('pubDate')->nullable();
            $table->string('image_url')->nullable();
            $table->string('source_id')->nullable();
            $table->string('category')->nullable();
            $table->string('country')->nullable();
            $table->string('language')->nullable();
            $table->longText('description')->nullable();
            $table->longText('content')->nullable();
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
        Schema::dropIfExists('news_data_articles');
    }
};
