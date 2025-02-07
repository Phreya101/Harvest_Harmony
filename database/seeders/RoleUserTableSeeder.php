<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('role_user')->insert([
            [
                'user_id' => 1, // Admin user
                'role_id' => 1, // Admin role
            ],
            [
                'user_id' => 2, // User 1
                'role_id' => 2, // User role
            ],
            [
                'user_id' => 3, // User 2
                'role_id' => 2, // User role
            ],
            [
                'user_id' => 4, // User 3
                'role_id' => 2, // User role
            ]
        ]);
    }
}
