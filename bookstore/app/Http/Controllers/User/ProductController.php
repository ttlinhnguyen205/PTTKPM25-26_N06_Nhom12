<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    public function show($id)
    {
        $book = Product::findOrFail($id);
        return view('user.detail', compact('book'));
    }
}
