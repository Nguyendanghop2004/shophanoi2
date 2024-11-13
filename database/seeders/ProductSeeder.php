<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'brand_id' => 1, // Giả sử brand_id này đã tồn tại
                'slug' => 'summer-dress',
                'product_name' => 'Summer Dress',
                'sku' => 'SD-001',
                'price' => 29.99,
                'status' => 1,
                'description' => 'A beautiful summer dress perfect for any occasion.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'brand_id' => 2,
                'slug' => 'winter-jacket',
                'product_name' => 'Winter Jacket',
                'sku' => 'WJ-002',
                'price' => 79.99,
                'status' => 1,
                'description' => 'A warm winter jacket to keep you cozy.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'brand_id' => 1,
                'slug' => 'cotton-tshirt',
                'product_name' => 'Cotton T-Shirt',
                'sku' => 'CT-003',
                'price' => 19.99,
                'status' => 1,
                'description' => 'Soft cotton t-shirt for everyday wear.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'brand_id' => 3,
                'slug' => 'denim-jeans',
                'product_name' => 'Denim Jeans',
                'sku' => 'DJ-004',
                'price' => 49.99,
                'status' => 1,
                'description' => 'Classic denim jeans for a casual look.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'brand_id' => 2,
                'slug' => 'silk-blouse',
                'product_name' => 'Silk Blouse',
                'sku' => 'SB-005',
                'price' => 39.99,
                'status' => 1,
                'description' => 'Elegant silk blouse for a sophisticated style.',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // Lấy ID cho các màu sắc và kích thước giả sử đã có
        $colorIds = [1, 2, 3, 4, 5]; // ID cho các màu sắc đã fake trước đó
        $sizeIds = [1, 2, 3, 4, 5]; // ID cho các kích thước đã fake trước đó

        DB::table('product_variants')->insert([
            // Biến thể cho sản phẩm Summer Dress
            [
                'product_id' => 1,
                'color_id' => $colorIds[0], // ID màu đầu tiên
                'size_id' => $sizeIds[0], // ID kích thước S
                'product_code' => 'SD-001-S-RED',
                'stock_quantity' => 10,
                'price' => 29.99,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 1,
                'color_id' => $colorIds[1],
                'size_id' => $sizeIds[1],
                'product_code' => 'SD-001-M-BLUE',
                'stock_quantity' => 15,
                'price' => 29.99,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Thêm 3 biến thể khác cho sản phẩm Summer Dress
            [
                'product_id' => 1,
                'color_id' => $colorIds[2],
                'size_id' => $sizeIds[2],
                'product_code' => 'SD-001-L-GREEN',
                'stock_quantity' => 20,
                'price' => 29.99,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 1,
                'color_id' => $colorIds[3],
                'size_id' => $sizeIds[3],
                'product_code' => 'SD-001-XL-YELLOW',
                'stock_quantity' => 5,
                'price' => 29.99,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 1,
                'color_id' => $colorIds[4],
                'size_id' => $sizeIds[4],
                'product_code' => 'SD-001-XXL-WHITE',
                'stock_quantity' => 8,
                'price' => 29.99,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Biến thể cho sản phẩm Winter Jacket
            [
                'product_id' => 2,
                'color_id' => $colorIds[0],
                'size_id' => $sizeIds[0],
                'product_code' => 'WJ-002-S-RED',
                'stock_quantity' => 12,
                'price' => 79.99,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Thêm 4 biến thể khác cho sản phẩm Winter Jacket
            [
                'product_id' => 2,
                'color_id' => $colorIds[1],
                'size_id' => $sizeIds[1],
                'product_code' => 'WJ-002-M-BLUE',
                'stock_quantity' => 18,
                'price' => 79.99,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 2,
                'color_id' => $colorIds[2],
                'size_id' => $sizeIds[2],
                'product_code' => 'WJ-002-L-GREEN',
                'stock_quantity' => 22,
                'price' => 79.99,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 2,
                'color_id' => $colorIds[3],
                'size_id' => $sizeIds[3],
                'product_code' => 'WJ-002-XL-YELLOW',
                'stock_quantity' => 7,
                'price' => 79.99,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 2,
                'color_id' => $colorIds[4],
                'size_id' => $sizeIds[4],
                'product_code' => 'WJ-002-XXL-WHITE',
                'stock_quantity' => 10,
                'price' => 79.99,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Thêm tương tự cho 3 sản phẩm còn lại
        ]);

        // Biến thể cho sản phẩm Cotton T-Shirt
        DB::table('product_variants')->insert([
            [
                'product_id' => 3,
                'color_id' => $colorIds[0], // ID màu Đỏ
                'size_id' => $sizeIds[0], // ID kích thước S
                'product_code' => 'CT-003-S-RED',
                'stock_quantity' => 25,
                'price' => 19.99,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 3,
                'color_id' => $colorIds[1], // ID màu Xanh
                'size_id' => $sizeIds[1], // ID kích thước M
                'product_code' => 'CT-003-M-BLUE',
                'stock_quantity' => 30,
                'price' => 19.99,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 3,
                'color_id' => $colorIds[2], // ID màu Vàng
                'size_id' => $sizeIds[2], // ID kích thước L
                'product_code' => 'CT-003-L-YELLOW',
                'stock_quantity' => 20,
                'price' => 19.99,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 3,
                'color_id' => $colorIds[3], // ID màu Xanh lá
                'size_id' => $sizeIds[3], // ID kích thước XL
                'product_code' => 'CT-003-XL-GREEN',
                'stock_quantity' => 15,
                'price' => 19.99,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 3,
                'color_id' => $colorIds[4], // ID màu Trắng
                'size_id' => $sizeIds[4], // ID kích thước XXL
                'product_code' => 'CT-003-XXL-WHITE',
                'stock_quantity' => 10,
                'price' => 19.99,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Biến thể cho sản phẩm Denim Jeans
        DB::table('product_variants')->insert([
            [
                'product_id' => 4,
                'color_id' => $colorIds[0], // ID màu Đỏ
                'size_id' => $sizeIds[0], // ID kích thước S
                'product_code' => 'DJ-004-S-RED',
                'stock_quantity' => 18,
                'price' => 49.99,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 4,
                'color_id' => $colorIds[1], // ID màu Xanh
                'size_id' => $sizeIds[1], // ID kích thước M
                'product_code' => 'DJ-004-M-BLUE',
                'stock_quantity' => 25,
                'price' => 49.99,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 4,
                'color_id' => $colorIds[2], // ID màu Vàng
                'size_id' => $sizeIds[2], // ID kích thước L
                'product_code' => 'DJ-004-L-YELLOW',
                'stock_quantity' => 12,
                'price' => 49.99,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 4,
                'color_id' => $colorIds[3], // ID màu Xanh lá
                'size_id' => $sizeIds[3], // ID kích thước XL
                'product_code' => 'DJ-004-XL-GREEN',
                'stock_quantity' => 8,
                'price' => 49.99,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 4,
                'color_id' => $colorIds[4], // ID màu Trắng
                'size_id' => $sizeIds[4], // ID kích thước XXL
                'product_code' => 'DJ-004-XXL-WHITE',
                'stock_quantity' => 15,
                'price' => 49.99,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Biến thể cho sản phẩm Silk Blouse
        DB::table('product_variants')->insert([
            [
                'product_id' => 5,
                'color_id' => $colorIds[0], // ID màu Đỏ
                'size_id' => $sizeIds[0], // ID kích thước S
                'product_code' => 'SB-005-S-RED',
                'stock_quantity' => 10,
                'price' => 39.99,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 5,
                'color_id' => $colorIds[1], // ID màu Xanh
                'size_id' => $sizeIds[1], // ID kích thước M
                'product_code' => 'SB-005-M-BLUE',
                'stock_quantity' => 12,
                'price' => 39.99,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 5,
                'color_id' => $colorIds[2], // ID màu Vàng
                'size_id' => $sizeIds[2], // ID kích thước L
                'product_code' => 'SB-005-L-YELLOW',
                'stock_quantity' => 8,
                'price' => 39.99,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 5,
                'color_id' => $colorIds[3], // ID màu Xanh lá
                'size_id' => $sizeIds[3], // ID kích thước XL
                'product_code' => 'SB-005-XL-GREEN',
                'stock_quantity' => 5,
                'price' => 39.99,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 5,
                'color_id' => $colorIds[4], // ID màu Trắng
                'size_id' => $sizeIds[4], // ID kích thước XXL
                'product_code' => 'SB-005-XXL-WHITE',
                'stock_quantity' => 7,
                'price' => 39.99,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        // ID các danh mục giả lập
        $categoryIds = [1, 2]; // Chỉ có 2 danh mục

        // Thêm dữ liệu mẫu vào bảng category_product
        DB::table('category_product')->insert([
            // Sản phẩm 1 - Graphic T-Shirt
            ['category_id' => $categoryIds[0], 'product_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['category_id' => $categoryIds[1], 'product_id' => 1, 'created_at' => now(), 'updated_at' => now()],

            // Sản phẩm 2 - Hoodie
            ['category_id' => $categoryIds[0], 'product_id' => 2, 'created_at' => now(), 'updated_at' => now()],

            // Sản phẩm 3 - Cotton T-Shirt
            ['category_id' => $categoryIds[0], 'product_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['category_id' => $categoryIds[1], 'product_id' => 3, 'created_at' => now(), 'updated_at' => now()],

            // Sản phẩm 4 - Denim Jeans
            ['category_id' => $categoryIds[1], 'product_id' => 4, 'created_at' => now(), 'updated_at' => now()],

            // Sản phẩm 5 - Silk Blouse
            ['category_id' => $categoryIds[0], 'product_id' => 5, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Mảng ID của sản phẩm và thẻ
        $productIds = range(1, 5); // ID sản phẩm từ 1 đến 5
        $tagIds = range(1, 7); // ID thẻ từ 1 đến 7
        // Thêm dữ liệu giả vào bảng product_tags
        $data = [];
        $existingPairs = []; // Mảng để lưu các cặp đã tồn tại

        while (count($data) < 20) { // Chỉ thêm 20 cặp
            // Chọn ngẫu nhiên sản phẩm và thẻ
            $productId = $productIds[array_rand($productIds)];
            $tagId = $tagIds[array_rand($tagIds)];

            // Tạo cặp
            $pair = "{$productId}_{$tagId}";

            // Kiểm tra xem cặp đã tồn tại chưa
            if (!in_array($pair, $existingPairs)) {
                $data[] = [
                    'product_id' => $productId,
                    'tag_id' => $tagId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                $existingPairs[] = $pair; // Thêm cặp vào mảng đã tồn tại
            }
        }

        // Chèn dữ liệu vào bảng product_tags
        DB::table('product_tags')->insert($data);


    }
}
