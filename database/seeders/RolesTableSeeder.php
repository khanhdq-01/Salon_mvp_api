<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run(): void
    {
        DB::table('roles')->insert([
            [
                'id' => 1,
                'name' => 'customer',
                'display_name' => 'Khách hàng',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'owner',
                'display_name' => 'Chủ salon',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'admin',
                'display_name' => 'Quản trị viên',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
