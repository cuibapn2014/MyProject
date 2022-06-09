<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertyProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_products', function (Blueprint $table) {
            $table->id();
            $table->string('CanNang', 10);
            $table->string('ChieuCao', 10);
            $table->bigInteger('SoLuong');
            $table->bigInteger('id_ChiTiet');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('property_products');
    }
}
