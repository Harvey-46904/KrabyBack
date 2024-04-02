<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pk');
            $table->unsignedBigInteger('amount');
            $table->tinyInteger('state');
            $table->string('date_created');
            $table->string('payment_method')->nullable();
            $table->string('url');
            $table->string('owner');
            $table->unsignedBigInteger('payed_amount');
            $table->string('description');
            $table->json('payment_method_enabled');
            $table->integer('expiration_days');
            $table->unsignedBigInteger('fee_amount');
            $table->decimal('iva_amount', 10, 2);
            $table->string('platform');
            $table->json('carrito');
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
        Schema::dropIfExists('pedidos');
    }
}
