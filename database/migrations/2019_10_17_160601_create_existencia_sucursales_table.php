<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExistenciaSucursalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('existencia_sucursales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('idsucursal')->unsigned();
            $table->bigInteger('idarticulo')->unsigned();
            $table->bigInteger('stock');
            $table->timestamps();

            $table->foreign('idsucursal')->references('id')->on('sucursales');
            $table->foreign('idarticulo')->references('id')->on('articulos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('existencia_sucursales');
    }
}
