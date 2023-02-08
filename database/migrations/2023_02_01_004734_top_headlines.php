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
        Schema::create('top_headlines', function (Blueprint $table) {
            $table->id();
            $table->string('source')->nullable();
            $table->string('author')->nullable();
            $table->string('category')->nullable();
            $table->longText('title')->nullable();
            $table->longText('description')->nullable();
            $table->longText('url')->nullable();
            $table->longText('urlToImage')->nullable();
            $table->string('publishedAt')->nullable();
            $table->longText('content')->nullable();
            $table->integer('favs')->default(0);
            $table->integer('readCount')->default(0);
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
        Schema::dropIfExists('top_headlines');
    }
};
