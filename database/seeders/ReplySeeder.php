<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReplySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sampleReplies = [
            "I totally agree with you!",
            "That’s an interesting point.",
            "Can you explain more?",
            "I think it depends on the situation.",
            "Nice insight!",
            "I have a different opinion on this.",
            "This is very helpful, thanks!",
            "I didn’t know that, thanks for sharing.",
            "That makes a lot of sense!",
            "I’ve experienced the same thing before.",
            "That's a great idea!",
            "I think there's another way to look at this.",
            "Good question! I'd like to hear more opinions.",
            "I love this discussion!",
            "I just learned something new today.",
            "I agree, but have you considered this?",
            "This topic is really engaging!",
            "I appreciate your perspective!",
            "Well said!",
            "I completely understand your point.",
        ];

        $replies = [];

        for ($i = 1; $i <= 200; $i++) { // Generate 200 replies
            $replies[] = [
                'reply' => $sampleReplies[array_rand($sampleReplies)], // Pick a random reply
                'comment_id' => rand(1, 50), // Random comment ID between 1 and 50
                'farmers_id' => [1, 3][array_rand([1, 3])], // Randomly assign farmer ID 1 or 3
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('replies')->insert($replies);
    }
}
