<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicioTecnicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicio_tecnicos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('idcliente')->unsigned();
            $table->foreign('idcliente')->references('id')->on('clientes');
            $table->bigInteger('idusuario')->unsigned();
            $table->foreign('idusuario')->references('id')->on('users');
            $table->bigInteger('idsucursal')->unsigned();
            $table->foreign('idsucursal')->references('id')->on('sucursales');
            $table->string('descipcion_equipo',256);
            $table->string('defectos_entrada', 256);
            $table->string('defectos_salida', 256);
            $table->dateTime('fecha_hora');
            $table->dateTime('fecha_hora_salida');
            $table->string('estado', 20);
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
        Schema::dropIfExists('servicio_tecnicos');
    }
}
