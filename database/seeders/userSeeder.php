<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('user')->insert([
            [
                'id' => 1,
                'email' => 'andisoewarna@gmail.com',
                'username' => 'andis',
                'name' => 'Andi Soewarna',
                'password' => '1234',
                'role' => 'Konsumen',
                'telepon' => '081326475678',
                'alamat' => 'Metro Pusat',
                'created_at' => now(), // Optional: add timestamps
                'updated_at' => now(), // Optional: add timestamps
            ],
            [
                'id' => 2,
                'email' => 'soe@marni.co.id',
                'username' => 'soemarny',
                'name' => 'Soemarni',
                'password' => '1234',
                'role' => 'Konsumen',
                'telepon' => '081326475679',
                'alamat' => 'Jakarta',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'email' => 'admin@yono.com',
                'username' => 'yoyon',
                'name' => 'Yono',
                'password' => '1234',
                'role' => 'Admin',
                'telepon' => '082374857677',
                'alamat' => 'Kidul',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'email' => 'owner@jokoko.com',
                'username' => 'jokoko',
                'name' => 'Joko Koesmanto',
                'password' => '1234',
                'role' => 'Owner',
                'telepon' => '081235463746',
                'alamat' => 'Kebon Sirih',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}