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
        Schema::create('vacaciones_d', function (Blueprint $table) {
            $table->id();
            $table->integer('vacaciones_h_id');
            $table->date('fecha');
            $table->decimal('valor', 6, 2);
            $table->string('estatus', 1)->default('A');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vacaciones_d');
    }
};
