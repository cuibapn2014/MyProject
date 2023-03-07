<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehouseExportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouse_exports', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->integer('type');
            $table->integer('id_ingredient');
            $table->integer('id_production');
            $table->integer('amount');
            $table->string('note')->nullable();
            $table->integer('status')->default(1)->comment('1:Chờ duyệt / 2: Đã duyệt');
            $table->date('export_date');
            $table->integer('id_creator');
            $table->integer('id_reviewer')->nullable();
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
        Schema::dropIfExists('warehouse_exports');
    }
}
