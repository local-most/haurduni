<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama', 150)->nullable();
            $table->unsignedInteger('kategori_id')->index();
            $table->unsignedInteger('satuan_id')->index();
            $table->string('harga', 50)->nullable();
            $table->string('berat', 10)->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('foto')->nullable();
            $table->string('warna_id')->nullable();
            $table->integer('stok')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('kategori_id')
                    ->references('id')
                    ->on('kategori')
                    ->onDelete('cascade');

            $table->foreign('satuan_id')
                    ->references('id')
                    ->on('satuan')
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
        Schema::dropIfExists('produk');
    }
}
