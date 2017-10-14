<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('options', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('desc')->nullable()->default('No description.');
            $table->string('tags')->nullable()->default('No tags.');
            $table->string('order');
            $table->integer('optiongroup_id')->nullable()->unsigned();
            $table->timestamps();

            $table->foreign('optiongroup_id')
                    ->references('id')->on('optiongroups')
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
        Schema::dropIfExists('options');
    }
}
