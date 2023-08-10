<?php

namespace Database\Seeders;

use App\Models\ChatBlockWords;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class BlockWordsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ChatBlockWords::truncate();
        $json = File::get("database/data/chat_block_words.json");
        $block_words = json_decode($json);

        foreach ($block_words as $key => $value) {
            ChatBlockWords::create([
                "block_words" => $value->block_words,
            ]);
        }
    }
}