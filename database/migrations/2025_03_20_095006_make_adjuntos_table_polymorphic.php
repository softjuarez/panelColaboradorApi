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
        Schema::table('adjuntos', function (Blueprint $table) {
            // Eliminamos la columna solicitud_id si existe
            if (Schema::hasColumn('adjuntos', 'solicitud_id')) {
                $table->dropForeign(['solicitud_id']);
                $table->dropColumn('solicitud_id');
            }

            // Agregamos las columnas polimórficas
            $table->unsignedBigInteger('adjuntable_id')->nullable();
            $table->string('adjuntable_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('adjuntos', function (Blueprint $table) {
            // Eliminamos las columnas polimórficas
            $table->dropColumn(['adjuntable_id', 'adjuntable_type']);

            // Si necesitas revertir, puedes agregar nuevamente la columna solicitud_id
            $table->unsignedBigInteger('solicitud_id')->nullable();
            $table->foreign('solicitud_id')->references('id')->on('solicitudes')->onDelete('cascade');
        });
    }
};
