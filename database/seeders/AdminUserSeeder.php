<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'KienLH',
                'username' => 'admin01',
                'email' => 'admin01@example.com',
                'password' => Hash::make('admin01'),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'User One',
                'username' => 'user01',
                'email' => 'user01@example.com',
                'password' => Hash::make('user01'),
                'role' => 'user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'User Two',
                'username' => 'user02',
                'email' => 'user02@example.com',
                'password' => Hash::make('user02'),
                'role' => 'user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'User Three',
                'username' => 'user03',
                'email' => 'user03@example.com',
                'password' => Hash::make('user03'),
                'role' => 'user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'User Four',
                'username' => 'user04',
                'email' => 'user04@example.com',
                'password' => Hash::make('user04'),
                'role' => 'user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'User Five',
                'username' => 'user05',
                'email' => 'user05@example.com',
                'password' => Hash::make('user05'),
                'role' => 'user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
