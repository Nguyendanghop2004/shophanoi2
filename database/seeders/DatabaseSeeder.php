<?php

// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();


        //    'name' => 'Test User',
        //     \App\Models\User::factory()->create([
        //  'email' => 'test@example.com',
        // ]);

        $this->call(CategoriesTableSeeder::class);
        $this->call(SlidersTableSeeder::class);

        $this->call(ColorSeeder::class);
        $this->call(BrandSeeder::class);
        $this->call(SizeSeeder::class);
        $this->call(TagSeeder::class);


    }
}

