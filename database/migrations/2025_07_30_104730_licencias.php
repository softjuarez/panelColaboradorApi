<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('licencias', function (Blueprint $table) {
            $table->id();
            $table->integer('usuario_crea');
            $table->string('estatus', 1)->default('A');
            $table->integer('ficha_crea');
            $table->text('razon_rechazo')->nullable();
            $table->integer('tipo');
            $table->text('descripcion');
            $table->date('fecha_evento')->nullable();
            $table->date('fecha_fin_evento')->nullable();
            $table->integer('usuario_atendio')->nullable();
            $table->date('fecha_atendio')->nullable();
            $table->text('respuesta')->nullable();
            $table->text('url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('licencias');
    }
};
