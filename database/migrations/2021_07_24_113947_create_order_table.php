<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->index();
            $table->datetime('tanggal')->nullable();
            $table->string('total_harga')->nullable();
            $table->string('total_tagihan')->nullable();
            $table->string('total_ongkir')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('status',10)->nullable();
            $table->string('bukti_pembayaran')->nullable();
            $table->boolean('is_delivered')->nullable();
            $table->unsignedInteger('wilayah_id')->index()->nullable();
            $table->text('alasan_tolak')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');

            $table->foreign('wilayah_id')
                    ->references('id')
                    ->on('wilayah')
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
        Schema::dropIfExists('order');
    }
}
