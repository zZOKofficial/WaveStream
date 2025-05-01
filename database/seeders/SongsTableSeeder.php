<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SongsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('songs')->insert([
            'title' => 'Test Song',
            'artist' => 'Test Artist',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
