<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'id' => 1,
                'name' => 'Women',
                'slug' => 'women',
                'description' => null,
                'image_path' => null,
                'parent_id' => null,
                'created_at' => null,
                'updated_at' => null,
                'deleted_at' => null
            ],
            [
                'id' => 2,
                'name' => 'Men',
                'slug' => 'men',
                'description' => null,
                'image_path' => null,
                'parent_id' => null,
                'created_at' => null,
                'updated_at' => null,
                'deleted_at' => null
            ]
        ]);
    }
}
