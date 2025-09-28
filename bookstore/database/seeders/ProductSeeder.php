<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Tạo 20 sản phẩm mẫu
        Product::factory()->count(20)->create();
    }
}
