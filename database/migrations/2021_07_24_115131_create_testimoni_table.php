<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestimoniTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('testimoni', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('produk_id')->index();
            $table->unsignedInteger('user_id')->index();
            $table->unsignedInteger('order_detail_id')->index();
            $table->string('keterangan')->nullable();
            $table->string('rate', 10)->nullable();
            $table->string('gambar')->nullable();
            $table->timestamps();

            $table->foreign('produk_id')
                    ->references('id')
                    ->on('produk')
                    ->onDelete('cascade');

            $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');

            $table->foreign('order_detail_id')
                    ->references('id')
                    ->on('order_detail')
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
        Schema::dropIfExists('testimoni');
    }
}
