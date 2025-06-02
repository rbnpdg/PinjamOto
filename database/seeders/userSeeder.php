<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('user')->insert([
            [
                'id' => 5,
                'email' => 'mardi@cust.com',
                'username' => 'marddy',
                'nama' => 'Soemardi',
                'password' => Hash::make('1234'),
                'role' => 'Konsumen',
                'telepon' => '081316475678',
                'alamat' => 'Metro Pusat',
                'created_at' => now(), // Optional: add timestamps
                'updated_at' => now(), // Optional: add timestamps
            ],
            [
                'id' => 6,
                'email' => 'admin@yono.com',
                'username' => 'yoyon',
                'nama' => 'Yono Sumarno',
                'password' => Hash::make('1234'),
                'role' => 'Admin',
                'telepon' => '082316475678',
                'alamat' => 'Metro Pusat',
                'created_at' => now(), // Optional: add timestamps
                'updated_at' => now(), // Optional: add timestamps
            ]
        ]);
    }
}