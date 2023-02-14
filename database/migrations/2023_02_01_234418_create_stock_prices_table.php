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
        Schema::create('stock_prices', function (Blueprint $table) {
            $table->id();
            $table->string('symbol')->nullable();
            $table->string('name')->nullable();
            $table->string('market')->nullable();
            $table->string('locale')->nullable();
            $table->string('primary_exchange')->nullable();
            $table->string('type')->nullable();
            $table->boolean('active')->nullable();
            $table->string('currency_name')->nullable();
            $table->string('cik')->nullable();
            $table->string('composite_figi')->nullable();
            $table->string('last_updated_utc')->nullable();
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
        Schema::dropIfExists('stock_prices');
    }
};
