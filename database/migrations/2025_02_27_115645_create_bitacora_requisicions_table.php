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
        Schema::create('bitacora_requisicion', function (Blueprint $table) {
            $table->id();
            $table->integer('requisicion_h');
            $table->integer('entidad_id');
            $table->datetime('fecha');
            $table->integer('usuario');
            $table->string('accion');
            $table->string('modelo');
            $table->text('descripcion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bitacora_requisicion');
    }
};
