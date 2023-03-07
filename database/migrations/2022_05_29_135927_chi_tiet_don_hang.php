<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChiTietDonHang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('detail_orders', function(Blueprint $table){
            $table->id();
            $table->bigInteger('id_DonHang');
            $table->bigInteger('id_product');
            $table->bigInteger('price');
            $table->integer('amount');
            $table->integer('SoLuong')->nullable();
            $table->text('image')->nullable();
            $table->integer('id_ChatLuong');
            $table->timestamps();
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
        Schema::dropIfExists('detail_orders');
    }
}
