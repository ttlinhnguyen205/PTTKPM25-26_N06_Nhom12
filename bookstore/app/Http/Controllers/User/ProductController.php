<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Hiển thị chi tiết 1 sản phẩm
    public function show($id)
    {
        // Lấy sản phẩm theo ID
        $product = Product::findOrFail($id);

        // Gửi dữ liệu sang view detail.blade.php
        return view('detail', compact('product'));
    }
}
