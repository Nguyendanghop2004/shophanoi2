<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SlidersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sliders')->insert([
            [
                'id' => 1,
                'title' => 'First Slider',
                'short_description' => 'Short description for the first slider',
                'image_path' => 'images/slider1.jpg',
                'link_url' => 'http://example.com',
                'position' => 1,
                'is_active' => 1,
                'category_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'id' => 2,
                'title' => 'Second Slider',
                'short_description' => 'Short description for the second slider',
                'image_path' => 'images/slider2.jpg',
                'link_url' => 'http://example.com',
                'position' => 2,
                'is_active' => 1,
                'category_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ]
        ]);
    }
}
