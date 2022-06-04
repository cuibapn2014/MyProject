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
        Schema::create('chi_tiet_don_hang', function(Blueprint $table){
            $table->id();
            $table->string('TenSP')->nullable();
            $table->integer('id_DanhMuc');
            $table->integer('id_LoaiVai')->nullable();
            $table->integer('id_PhuLieu')->nullable();
            $table->integer('SoLuong')->nullable();
            $table->string('KichThuoc');
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
        Schema::dropIfExists('chi_tiet_don_hang');
    }
}
