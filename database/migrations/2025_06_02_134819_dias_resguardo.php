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
        Schema::table('configuraciones', function (Blueprint $table) {
            $table->decimal('dias_resguardo_semana_santa', 8, 2)->default(0);
            $table->decimal('dias_resguardo_fin_anio', 8, 2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('configuraciones', function (Blueprint $table) {
            $table->dropColumn(['dias_resguardo_semana_santa']);
            $table->dropColumn(['dias_resguardo_fin_anio']);
        });
    }
};
