<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFabricDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fabric_details', function (Blueprint $table) {
            $table->id();
            $table->integer('id_LoaiVai');
            $table->integer('id_ChiTiet');
            $table->string('Loai')->nullable()->max(50);
            $table->integer('ChieuDai')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fabric_details');
    }
}
