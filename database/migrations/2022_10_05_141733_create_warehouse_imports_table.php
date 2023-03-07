<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehouseImportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouse_imports', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->integer('id_ingredient');
            $table->integer('type');
            $table->integer('id_production');
            $table->bigInteger('amount');
            $table->bigInteger('paid')->default(0);
            $table->bigInteger('price')->default(0);
            $table->string('note');
            $table->integer('status')->default(1)->comment('1: Chờ duyệt, 2: Đã duyệt');
            $table->date('import_date');
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
        Schema::dropIfExists('warehouse_imports');
    }
}
