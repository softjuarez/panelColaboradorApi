<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentoDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documento_detalles', function (Blueprint $table) {
            $table->id();
            $table->integer('documento_id');
            $table->integer('linea');
            $table->string('descripcion', 512);
            $table->string('bien_servicio', 1);
            $table->string('exento_sn', 1)->default('N');
            $table->decimal('cantidad', 16, 2);
            $table->string('um', 15);
            $table->decimal('precio_uni', 16, 2);
            $table->decimal('valor_total', 16, 2);
            $table->decimal('valor_descuento', 16, 2);
            $table->decimal('valor_iva', 16, 2);
            $table->decimal('valor_impuestos', 16, 2);
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
        Schema::dropIfExists('documento_detalles');
    }
}
