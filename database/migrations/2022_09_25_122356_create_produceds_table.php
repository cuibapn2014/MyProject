<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProducedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produceds', function (Blueprint $table) {
            $table->id();
            $table->string('lot_number')->max(12);
            $table->integer('id_production');
            $table->bigInteger('amount');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('creator');
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
        Schema::dropIfExists('produceds');
    }
}
