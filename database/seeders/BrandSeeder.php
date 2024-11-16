<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('brands')->insert([
            [
                'name' => 'Nike',
                'image_brand_url' => 'https://example.com/images/nike.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Adidas',
                'image_brand_url' => 'https://example.com/images/adidas.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Puma',
                'image_brand_url' => 'https://example.com/images/puma.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Reebok',
                'image_brand_url' => 'https://example.com/images/reebok.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Under Armour',
                'image_brand_url' => 'https://example.com/images/underarmour.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'New Balance',
                'image_brand_url' => 'https://example.com/images/newbalance.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Asics',
                'image_brand_url' => 'https://example.com/images/asics.png',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

    }
}
