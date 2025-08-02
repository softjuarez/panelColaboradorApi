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
        Schema::table('archivos_requisicion', function (Blueprint $table) {
            $table->string('etapa', 1)->default('A')->after('requisicion_h');
            $table->integer('user_id')->nullable()->after('etapa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('archivos_requisicion', function (Blueprint $table) {
            $table->dropColumn(['etapa', 'user_id']);
        });
    }
};
