<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\RolesTableSeeder;
use Database\Seeders\CategoryGroupSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\CommentSeeder;
use Database\Seeders\equipments;
use Database\Seeders\ReplySeeder;
use Database\Seeders\RoleUserTableSeeder;
use Database\Seeders\ThreadsTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesTableSeeder::class,
            UsersTableSeeder::class,
            CategoryGroupSeeder::class,
            CategorySeeder::class,
            CommentSeeder::class,
            equipments::class,
            ReplySeeder::class,
            RoleUserTableSeeder::class,
            ThreadsTableSeeder::class

        ]);
    }
}
