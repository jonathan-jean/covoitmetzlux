<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('travel_id')->unsigned();
            $table->integer('from')->unsigned();
            $table->integer('to')->unsigned();
            $table->boolean('answered');
            $table->timestamps();
            $table->foreign('to')
                ->references('id')->on('users')
                ->onDelete('cascade');
            $table->foreign('from')
                ->references('id')->on('users')
                ->onDelete('cascade');
            $table->foreign('travel_id')
                ->references('id')->on('travels')
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
        Schema::dropIfExists('contacts');
    }
}
