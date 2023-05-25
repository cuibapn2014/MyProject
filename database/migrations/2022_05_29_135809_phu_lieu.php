<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PhuLieu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('ingredients', function (Blueprint $table){
            $table->id();
            $table->string('code')->max(10);
            $table->string('Ten');
            $table->string('GhiChu')->nullable();
            $table->bigInteger('id_ingredient_type');
            $table->bigInteger('id_provider')->nullable();
            $table->bigInteger('amount')->default(0);       
            $table->bigInteger('used_amount')->default(0);       
            $table->integer('stage')->default(1);       
            $table->integer('id_unit');       
            $table->bigInteger('Gia')->nullable();       
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
        Schema::dropIfExists('ingredients');
    }
}
