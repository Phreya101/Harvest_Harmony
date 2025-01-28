<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CommentSeeder extends Seeder
{
    public function run()
    {
        $comments = [
            "This is an interesting discussion!",
            "I totally agree with you!",
            "Can you provide more details?",
            "That's a great idea!",
            "I have experienced the same thing.",
            "Thanks for sharing!",
            "What do you think about this?",
            "This could be improved by...",
            "I would love to learn more!",
            "Great insights!",
        ];

        for ($i = 1; $i <= 50; $i++) { // Generate 50 random comments
            DB::table('comments')->insert([
                'comment' => $comments[array_rand($comments)], // Random comment
                'thread_id' => rand(1, 49), // Random thread ID (1-49)
                'farmers_id' => rand(0, 1) ? 1 : 3, // Randomly assign user 1 or 3
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
