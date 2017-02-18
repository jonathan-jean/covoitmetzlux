<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTravelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travels', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('departure');
            $table->decimal('departure_lat', 10, 7);
            $table->decimal('departure_long', 10, 7);
            $table->string('arrival');
            $table->decimal('arrival_lat', 10, 7);
            $table->decimal('arrival_long', 10, 7);
            $table->dateTime('date');
            $table->integer('places');
            $table->text('information');
            $table->timestamps();
            $table->foreign('user_id')
                ->references('id')->on('users')
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
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('travels');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
