<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInquiriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inquiries', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->bigIncrements('id');
            $table->string('name');
            $table->timestampTz('timestamp');
            $table->string('email');
            $table->string('phone');
            $table->date('departure');
            $table->tinyInteger('adult')->unsigned();
            $table->tinyInteger('child')->unsigned();
            $table->string('comments');
            $table->smallInteger('product_id')->unsigned();
            $table->enum('product', ['cruiseships', 'excursions', 'packages']);
            $table->boolean('is_readed')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inquiries');
    }
}
