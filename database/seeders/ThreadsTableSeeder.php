<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ThreadsTableSeeder extends Seeder
{
    public function run()
    {
        $titles = [
            "Best organic fertilizers for rice?",
            "How to prevent pest infestation in corn?",
            "What is the best irrigation method for vegetables?",
            "How to improve soil fertility naturally?",
            "Best crop rotation practices?",
            "How to increase yield in tomato farming?",
            "Is hydroponics worth it for small farmers?",
            "Organic farming vs traditional farming?",
            "How to start beekeeping as a side business?",
            "Best time to plant soybeans?",
            "How to deal with fungal infections in crops?",
            "What is the best breed of chicken for free-range farming?",
            "How to test soil pH at home?",
            "Best companion planting combinations?",
            "How to make compost at home?",
            "How to protect crops from extreme heat?",
            "What is the best way to store harvested grains?",
            "Best crops to plant during the rainy season?",
            "How to reduce water usage in farming?",
            "How to set up a drip irrigation system?",
            "What are the benefits of vermiculture?",
            "How to identify nitrogen deficiency in plants?",
            "How to start a small-scale dairy farm?",
            "What are the best cover crops?",
            "How to attract pollinators to your farm?",
            "Best farming techniques for clay soil?",
            "How to start mushroom farming?",
            "How to prevent weeds naturally?",
            "What is the best fertilizer for fruit trees?",
            "How to raise goats for milk production?",
            "How to start fish farming in a small pond?",
            "How to market farm products effectively?",
            "How to grow herbs indoors?",
            "What are the common plant diseases?",
            "How to build a greenhouse on a budget?",
            "How to raise ducks for egg production?",
            "What are the best drought-resistant crops?",
            "How to prevent erosion on farmlands?",
            "What are the best crops for vertical farming?",
            "How to grow strawberries organically?",
            "Best plants for intercropping?",
            "How to raise quails for meat and eggs?",
            "How to use biochar in farming?",
            "What is the best season to plant peanuts?",
            "How to make your own organic pesticide?",
            "Best farm animals for beginners?",
            "How to build a low-cost chicken coop?",
            "How to process and store harvested rice?",
            "How to get funding for a farm startup?"
        ];

        for ($i = 0; $i < count($titles); $i++) {
            DB::table('threads')->insert([
                'title' => $titles[$i], // Access title directly by index
                'category_id' => rand(1, 25),
                'farmers_id' => (rand(0, 1) == 0) ? 1 : 3, // Randomly pick between 1 and 3
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
