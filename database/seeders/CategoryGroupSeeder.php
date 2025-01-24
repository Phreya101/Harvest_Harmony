<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Farming Discussions & Best Practices'],
            ['name' => 'Livestock & Animal Husbandry'],
            ['name' => 'Agricultural Technology & Innovations'],
            ['name' => 'Farming Business & Market Trends'],
            ['name' => 'Climate & Environmental Concerns'],
            ['name' => 'Learning Resources & Expert Advice'],
            ['name' => 'Farm Machinery & Equipment'],
            ['name' => 'Machinery Maintenance & Repair'],
        ];

        DB::table('category_group')->insert($categories);
    }
}
