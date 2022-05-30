<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CongViec extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('cong_viec', function(Blueprint $table) {
            $table->id();
            $table->bigInteger('id_nguoi_giao');
            $table->string('chi_tiet')->nullable();
            $table->timestamp('ngay_hoan_thanh');
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
        Schema::dropIfExists('cong_viec');
    }
}
