<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestProductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_productions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_ingredient');
            $table->bigInteger('id_production_request');
            $table->bigInteger('amount')->default(0);
            $table->integer('status')->default(1);
            $table->integer('censor');
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
        Schema::dropIfExists('request_productions');
    }
}
