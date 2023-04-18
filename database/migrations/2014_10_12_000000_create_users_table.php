<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama', 50);
            $table->string('username', 50)->unique();
            $table->string('email', 50)->nullable();
            $table->string('password');
            $table->string('role', 2);
            $table->unsignedInteger('wilayah_id')->index()->nullable();
            $table->text('alamat')->nullable();
            $table->string('nohp', 15)->nullable();
            $table->string('foto')->nullable();
            $table->string('ktp')->nullable();
            $table->boolean('validate')->default(0);
            $table->string('alasan')->nullable();
            $table->rememberToken();
            $table->timestamps();

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
        Schema::dropIfExists('users');
    }
}
