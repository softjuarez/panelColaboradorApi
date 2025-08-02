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
        Schema::create('conexiones_nodos', function (Blueprint $table) {
            $table->id();
            $table->integer('organigrama_id');
            $table->integer('nodo_padre_id');
            $table->integer('nodo_hijo_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conexiones_nodos');
    }
};
