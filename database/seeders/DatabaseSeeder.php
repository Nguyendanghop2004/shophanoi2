<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call(CategoriesTableSeeder::class);
        $this->call(SlidersTableSeeder::class);

        $this->call(ColorSeeder::class);
        $this->call(BrandSeeder::class);
        $this->call(SizeSeeder::class);
        $this->call(TagSeeder::class);
        $this->call(ProductSeeder::class);
    }
}
