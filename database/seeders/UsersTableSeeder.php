<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'id' => (string) Str::uuid(),
            'role_id' => 1, // id của role 'customer'
            'name' => 'customer',
            'email' => 'customer@example.com',
            'password' => Hash::make('password123'),
            'phone' => '0123456789',
            'status' => 'active',
            'last_login' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}