<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Gia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('gia', function(Blueprint $table){
            $table->id();
            $table->integer('id_ChatLuong');
            $table->unsignedFloat('Gia');
            $table->bigInteger('LimitStart');
            $table->bigInteger('LimitFinish');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('gia');
    }
}
