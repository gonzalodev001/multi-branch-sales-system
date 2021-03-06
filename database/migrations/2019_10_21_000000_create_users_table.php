<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigInteger('id')->unsigned();
            $table->foreign('id')->references('id')->on('personas')->onDelete('cascade');

            $table->string('usuario',20)->unique();
            $table->string('password');
            $table->boolean('condicion')->default(1);

            $table->bigInteger('idrol')->unsigned();
            $table->foreign('idrol')->references('id')->on('roles');

            $table->bigInteger('idsucursal')->unsigned();
            $table->foreign('idsucursal')->references('id')->on('sucursales');

            $table->rememberToken();
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
