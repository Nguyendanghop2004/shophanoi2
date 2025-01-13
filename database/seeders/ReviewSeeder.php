<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\Order;
use App\Models\Product;

class ReviewSeeder extends Seeder
{
    public function run()
    {
        // Fake dữ liệu cho Review
        Review::factory(10)->create();  
    }
}
