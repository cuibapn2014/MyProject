<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class HangMay extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('hang_may', function(Blueprint $table){
            $table->id();
            $table->integer('id_DonHang');
            $table->unsignedFloat('TienCoc');
            $table->unsignedFloat('TongTien');
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
        Schema::dropIfExists('hang_may');
    }
}
