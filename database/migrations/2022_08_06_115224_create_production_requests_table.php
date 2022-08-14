<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductionRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('production_requests', function (Blueprint $table) {// Sản phẩm hoàn thiện
            $table->id();
            $table->bigInteger('detail_order_id');
            $table->string('code');
            $table->string('name');
            $table->string('size')->nullable();
            $table->string('color')->nullable();
            $table->integer('amount')->min(1);
            $table->integer('completed')->default(0);
            $table->string('image')->nullable()->default('placeholder.jpg');
            $table->string('note')->nullable();
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
        Schema::dropIfExists('production_requests');
    }
}
