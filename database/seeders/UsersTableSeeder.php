<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Juan Dela Cruz',
                'address' => '123 Sampaguita St., Manila, Philippines',
                'number' => '09123456789',
                'email' => 'juan.delacruz@example.com',
                'password' => Hash::make('password123'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Maria Santos',
                'address' => '456 Rizal Ave., Quezon City, Philippines',
                'number' => '09234567890',
                'email' => 'maria.santos@example.com',
                'password' => Hash::make('password123'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Pedro Ramos',
                'address' => '789 Mabini St., Cebu City, Philippines',
                'number' => '09345678901',
                'email' => 'pedro.ramos@example.com',
                'password' => Hash::make('password123'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Ana Reyes',
                'address' => '101 Bonifacio St., Davao City, Philippines',
                'number' => '09456789012',
                'email' => 'ana.reyes@example.com',
                'password' => Hash::make('password123'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
