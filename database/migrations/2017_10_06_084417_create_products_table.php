<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('shortDesc')->nullable()->default('No description.');
            $table->string('longDesc')->nullable()->default('No description.');
            $table->string('imgs')->nullable();
            $table->string('links')->nullable();
            $table->string('tags')->nullable()->default('No tags.');
            $table->integer('order')->default(1);
            $table->boolean('state')->nullable()->default(0);
            $table->integer('category_id')->unsigned();
            $table->integer('serie_id')->unsigned();
            $table->timestamps();

            $table->foreign('category_id')
                    ->references('id')->on('categories')
                      ->onDelete('cascade');

            $table->foreign('serie_id')
                    ->references('id')->on('series')
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
        Schema::dropIfExists('products');
    }
}
