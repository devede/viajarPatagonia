<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePricesCruiseshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prices_cruiseships', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->smallIncrements('id');
            $table->mediumInteger('price');
            $table->mediumInteger('discount');
            $table->boolean('is_active')->default(false);
            $table->tinyInteger('fk_currency')->unsigned();
            $table->smallInteger('fk_cruiseship')->unsigned();

            $table->foreign('fk_currency')->references('id')->on('currencies');
            $table->foreign('fk_cruiseship')->references('id')->on('cruiseships');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prices_cruiseships');
    }
}
