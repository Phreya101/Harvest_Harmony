<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run()
    {
        // Define the categories along with their group_id
        $categories = [
            'Farming Discussions & Best Practices' => [
                'Crop Cultivation Techniques',
                'Sustainable Farming Methods',
                'Organic Farming & Pest Control',
                'Soil Health & Fertilization',
            ],
            'Livestock & Animal Husbandry' => [
                'Poultry Farming',
                'Cattle & Dairy Farming',
                'Fish & Aquaculture',
                'Animal Health & Veterinary Advice',
            ],
            'Agricultural Technology & Innovations' => [
                'Smart Farming & IoT in Agriculture',
                'Use of Drones & Automation',
                'Hydroponics & Vertical Farming',
                'Best Farming Tools & Equipment',
            ],
            'Farming Business & Market Trends' => [
                'Selling & Marketing Farm Products',
                'Government Grants & Subsidies',
                'Export & Trade Opportunities',
                'Farm Budgeting & Financial Management',
            ],
            'Climate & Environmental Concerns' => [
                'Weather & Climate Change Impacts',
                'Water Conservation Techniques',
                'Agroforestry & Sustainable Land Use',
                'Disaster Preparedness for Farmers',
            ],
            'Learning Resources & Expert Advice' => [
                'Farming Guides & Tutorials',
                'Q&A with Agricultural Experts',
                'Webinars & Training Sessions',
                'Recommended Books & Research Papers',
            ],
            'Farm Machinery & Equipment' => [
                'Plowing & Soil Preparation',
                'Irrigation Systems & Water Management',
                'Harvesting Equipment',
                'Post-Harvest Processing & Storage',
            ],
            'Machinery Maintenance & Repair' => [
                'Troubleshooting Common Issues',
                'DIY Repairs & Maintenance Tips',
                'Spare Parts & Replacements',
                'Engine & Hydraulic System Care',
            ],
        ];

        // Insert categories with corresponding group_id
        foreach ($categories as $groupName => $options) {
            // Get the group_id based on the group name
            $groupId = DB::table('category_group')->where('name', $groupName)->value('id');

            // Insert each category
            foreach ($options as $option) {
                DB::table('category')->insert([
                    'group_id' => $groupId,  // Set the group_id
                    'name' => $option,       // Set the category name
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
