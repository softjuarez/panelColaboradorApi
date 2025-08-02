<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documentos', function (Blueprint $table) {
            $table->id();
            $table->integer('proveedor_id');
            $table->integer('empresa_id');
            $table->integer('ordcom_h')->nullable();
            $table->string('estatus', 1);
            $table->string('estado_retencion', 1)->default('P');
            $table->string('serie', 15)->nullable();
            $table->string('numero_docto', 15)->nullable();
            $table->string('uuid', 50)->nullable();
            $table->string('referencia', 50)->nullable();
            $table->string('clasificacion', 1)->nullable();
            $table->date('fecha_docto')->nullable();
            $table->date('fecha_vence')->nullable();
            $table->date('fecha_pago')->nullable();
            $table->decimal('valor_iva', 16, 2)->nullable();
            $table->decimal('valor_impuestos', 16, 2)->nullable();
            $table->decimal('valor_gran_total', 16, 2)->default(0);
            $table->decimal('valor_pagado', 16, 2)->nullable();
            $table->decimal('valor_retencion', 16, 2)->nullable();
            $table->string('path_retencion', 200)->nullable();
            $table->string('pdf', 200)->nullable();
            $table->string('xml', 200)->nullable();
            $table->string('justificacion', 256)->nullable();
            $table->string('moneda', 3)->nullable();
            $table->string('rechazo', 256)->nullable();
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
        Schema::dropIfExists('documentos');
    }
}
