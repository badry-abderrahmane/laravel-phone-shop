<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptiongroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('optiongroups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('desc')->nullable()->default('No description.');
            $table->string('tags')->nullable()->default('No tags.');
            $table->integer('order');
            $table->integer('category_id')->nullable()->unsigned();
            $table->timestamps();
            
            $table->foreign('category_id')
                    ->references('id')->on('categories')
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
        Schema::dropIfExists('optiongroups');
    }
}
