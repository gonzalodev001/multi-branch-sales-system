<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIngresosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingresos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('idproveedor')->unsigned();
            $table->foreign('idproveedor')->references('idp')->on('proveedores');
            $table->bigInteger('idusuario')->unsigned();
            $table->foreign('idusuario')->references('id')->on('users');
            $table->bigInteger('idsucursal')->unsigned();
            $table->foreign('idsucursal')->references('id')->on('sucursales');
            $table->string('tipo_comprobante',20);
            $table->string('numero_comprobante',10);
            $table->dateTime('fecha_hora');
            $table->decimal('impuesto',4,2);
            $table->decimal('total_compra',11,2);
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
        Schema::dropIfExists('ingresos');
    }
}
