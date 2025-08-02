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
            $table->unsignedBigInteger('tipo_id')->default(0)->after('url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('adjuntos', function (Blueprint $table) {
            $table->dropColumn('tipo_id');
        });
    }
};
