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
            $table->text('motivo')->nullable();
            $table->text('detalle_motivo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vacaciones_h', function (Blueprint $table) {
            $table->dropColumn(['motivo', 'detalle_motivo']);
        });
    }
};
