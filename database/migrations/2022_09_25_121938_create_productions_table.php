<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productions', function (Blueprint $table) {
            $table->id();
            $table->string('code')->max(10);
            $table->integer('id_product');
            $table->integer('id_plan_ingredient');
            $table->integer('id_production_request');
            $table->integer('require_total')->default(0);
            $table->integer('status')->default(0);
            $table->string('note')->nullable();
            $table->integer('creator');
            $table->integer('priority');
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
        Schema::dropIfExists('productions');
    }
}
