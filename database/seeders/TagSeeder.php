<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tags')->insert([
            [
                'name' => 'Summer Collection',
                'type' => 'collection',
                'description' => 'A collection of summer-themed clothing.',
                'background_image' => 'https://example.com/images/summer-collection.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Winter Collection',
                'type' => 'collection',
                'description' => 'A collection of winter-themed clothing.',
                'background_image' => 'https://example.com/images/winter-collection.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Cotton',
                'type' => 'material',
                'description' => 'Soft and breathable fabric.',
                'background_image' => 'https://example.com/images/cotton.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Denim',
                'type' => 'material',
                'description' => 'Durable material commonly used for jeans.',
                'background_image' => 'https://example.com/images/denim.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Silk',
                'type' => 'material',
                'description' => 'Luxurious fabric with a smooth finish.',
                'background_image' => 'https://example.com/images/silk.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Autumn Collection',
                'type' => 'collection',
                'description' => 'Clothing items perfect for autumn weather.',
                'background_image' => 'https://example.com/images/autumn-collection.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Linen',
                'type' => 'material',
                'description' => 'Lightweight fabric ideal for summer wear.',
                'background_image' => 'https://example.com/images/linen.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

    }
}
