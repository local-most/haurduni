<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('order_id')->index();
            $table->unsignedInteger('produk_id')->index();
            $table->string('jumlah')->nullable();
            $table->string('harga')->nullable();
            $table->string('warna_id')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('order_id')
                    ->references('id')
                    ->on('order')
                    ->onDelete('cascade');

            $table->foreign('produk_id')
                    ->references('id')
                    ->on('produk')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_detail');
    }
}
