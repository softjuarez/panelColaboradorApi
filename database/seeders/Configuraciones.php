<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Configuraciones extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('configuraciones')->insert([
            'limite' => 1500.00, // Límite inicial
            'validador_monto_mayor' => 1, // Validador para montos mayores
            'validador_monto_menor' => 1, // Validador para montos menores
            'created_at' => now(), // Fecha de creación
            'updated_at' => now(), // Fecha de actualización
        ]);
    }
}
