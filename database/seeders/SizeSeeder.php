<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sizes')->insert([
            [
                'name' => 'XS',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'S',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'M',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'L',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'XL',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'XXL',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'XXXL',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

    }
}
