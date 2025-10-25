<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    /**
     * Hiển thị trang chi tiết sản phẩm.
     */
    public function show($id)
    {
        // Lấy sản phẩm kèm danh mục
        $book = Product::with('category')->findOrFail($id);

        // Lấy các sản phẩm khác cùng danh mục (trừ sản phẩm hiện tại)
        $relatedBooks = Product::where('category_id', $book->category_id)
                            ->where('id', '!=', $book->id)
                            ->take(4)
                            ->get();

        // Trả dữ liệu sang view
        return view('user.detail', compact('book', 'relatedBooks'));
    }

    /**
     * Hiển thị danh sách tất cả sản phẩm (nếu bạn cần trang Shop).
     */
    public function index()
    {
        $products = Product::latest()->paginate(12);
        $categories = Category::orderBy('name')->get();

        return view('user.shop', compact('products', 'categories'));
    }
}
