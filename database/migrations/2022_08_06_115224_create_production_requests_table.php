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
            $table->integer('detail_order_id');
            $table->integer('id_product');
            $table->string('code')->nullable();
            $table->string('size')->nullable();
            $table->string('color')->nullable();
            $table->integer('amount')->min(0);
            $table->integer('completed')->default(0);
            $table->string('image')->nullable()->default('placeholder.jpg');
            $table->string('note')->nullable();
            $table->integer('creator');
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('production_requests');
    }
}
