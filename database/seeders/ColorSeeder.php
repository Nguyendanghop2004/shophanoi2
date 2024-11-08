<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('colors')->insert([
            [
                'name' => 'Red',
                'sku_color' => '#FF0000',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Green',
                'sku_color' => '#00FF00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Blue',
                'sku_color' => '#0000FF',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Yellow',
                'sku_color' => '#FFFF00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Purple',
                'sku_color' => '#800080',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Black',
                'sku_color' => '#000000',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'White',
                'sku_color' => '#FFFFFF',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
