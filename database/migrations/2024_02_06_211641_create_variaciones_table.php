<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('menus_id');
            $table->foreign('menus_id')->references('id')->on('menus')->onDelete('cascade');
            $table->string("nombre_variacion");
            $table->json("opciones");
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
        Schema::dropIfExists('variaciones');
    }
}
