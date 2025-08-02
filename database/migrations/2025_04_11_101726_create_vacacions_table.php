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
        Schema::create('vacaciones_h', function (Blueprint $table) {
            $table->id();
            $table->string('empresa');
            $table->integer('ficha');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->decimal('dias_otorgados', 6, 2)->default(0);
            $table->decimal('dias_solicitados', 6, 2);
            $table->string('periodo', 9);
            $table->string('estatus', 1)->default('A');
            $table->integer('usuario_solicita');
            $table->integer('vacacion'); 
            $table->text('razon_autoriza')->nullable(); 
            $table->text('razon_rechazo')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vacaciones_h');
    }
};
