<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->text(255), // Tạo một tiêu đề ngẫu nhiên
            'content' => $this->faker->text(255), // Tạo nội dung ngẫu nhiên
            'image_path' => '', // Tạo đường dẫn hình ảnh ngẫu nhiên
            'published_at' => $this->faker->dateTimeBetween('-1 year', 'now'), // Ngày xuất bản ngẫu nhiên
            'category_id' => $this->faker->numberBetween(1, 20), // ID danh mục ngẫu nhiên
            'product_id' => $this->faker->numberBetween(1, 20), 
        ];
    }
}
