<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductaccessoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productaccessories', function (Blueprint $table) {
          $table->increments('id');
          $table->string('tags')->nullable();
          $table->integer('product_id')->unsigned();
          $table->integer('accessory_id')->unsigned();
          $table->timestamps();

          $table->foreign('product_id')
                  ->references('id')->on('products')
                      ->onDelete('cascade');

          $table->foreign('accessory_id')
                  ->references('id')->on('accessories')
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
        Schema::dropIfExists('productaccessories');
    }
}
