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
        Schema::table('vacaciones_h', function (Blueprint $table) {
            $table->integer('usuario_autoriza')->nullable();
            $table->integer('usuario_verifica')->nullable();
            $table->datetime('fecha_autoriza')->nullable();
            $table->datetime('fecha_verifica')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vacaciones_h', function (Blueprint $table) {
            $table->dropColumn(['usuario_autoriza', 'usuario_verifica', 'fecha_autoriza', 'fecha_verifica']);
        });
    }
};
