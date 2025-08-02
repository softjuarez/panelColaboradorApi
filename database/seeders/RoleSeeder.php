<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert(
            ['name' => 'Administrador', 'created_at' => date('Ymd'), 'updated_at' => date('Ymd')]
        );

        DB::table('permission_role')->delete();
        $permissions = DB::table('permissions')->pluck('id');
        foreach ($permissions as $permission) {
            DB::table('permission_role')->insert([
                ['role_id' => 1, 'permission_id' => $permission]
            ]);
        }
    }
}
