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
        Schema::table('users', function (Blueprint $table) {
            $table->decimal('limite', 18, 2)->nullable(); // Campo para el límite
            $table->integer('validador_monto_mayor')->nullable(); // Campo para el validador de montos mayores
            $table->integer('validador_monto_menor')->nullable(); // Campo para el validador de montos menores
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('limite');
            $table->dropColumn('validador_montos_mayores');
            $table->dropColumn('validador_montos_menores');
        });
    }
};
