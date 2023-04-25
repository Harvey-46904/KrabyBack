<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCentroComercialesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('centro_comerciales', function (Blueprint $table) {
            $table->id();
            $table->string("nombre_centro_comercial");
            $table->string("direccion");
            $table->integer("telefono");
            $table->string("correo");
            $table->string("ubicacion");
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
        Schema::dropIfExists('centro_comerciales');
    }
}
