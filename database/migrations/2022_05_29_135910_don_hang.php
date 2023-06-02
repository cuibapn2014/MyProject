<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DonHang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('orders', function(Blueprint $table){
            $table->id();
            $table->bigInteger('id_customer')->nullable();
            $table->string('code')->nullable();
            $table->integer('vat')->nullable();
            $table->bigInteger('total')->nullable();
            $table->bigInteger('paid')->nullable();
            $table->integer('status')->default(1);
            $table->string('note')->nullable();
            $table->dateTime('NgayTraDon')->nullable();
            $table->integer('id_NhanVien')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
