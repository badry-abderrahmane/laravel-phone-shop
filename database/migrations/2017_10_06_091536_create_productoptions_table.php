<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductoptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productoptions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('value');
            $table->string('desc')->nullable();
            $table->string('tags')->nullable();
            $table->integer('product_id')->unsigned();
            $table->integer('option_id')->unsigned();
            $table->timestamps();

            $table->foreign('product_id')
                    ->references('id')->on('products')
                        ->onDelete('cascade');

            $table->foreign('option_id')
                    ->references('id')->on('options')
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
        Schema::dropIfExists('productoptions');
    }
}
