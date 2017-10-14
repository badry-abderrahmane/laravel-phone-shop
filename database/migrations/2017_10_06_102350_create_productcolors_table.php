<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductcolorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productcolors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('imgs');
            $table->string('desc');
            $table->string('tags');
            $table->integer('color_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->timestamps();

            $table->foreign('color_id')
                    ->references('id')->on('colors')
                        ->onDelete('cascade');
            $table->foreign('product_id')
                    ->references('id')->on('products')
                        ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productcolors');
    }
}
