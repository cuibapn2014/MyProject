<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LoaiVai extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('fabrics', function (Blueprint $table) {
            $table->id();
            $table->string('Ten')->unique()->max(50);
            $table->string('MauSac')->max(50);
            $table->string('TinhChat')->nullable();
            $table->text('GhiChu')->nullable();
            $table->unsignedFloat('Gia');
            $table->text('DiaChiMua')->nullable();
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
        Schema::dropIfExists('fabrics');
    }
}
