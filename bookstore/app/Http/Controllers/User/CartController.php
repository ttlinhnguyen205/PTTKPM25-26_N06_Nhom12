<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart', []);
        return view('user.cart.index', compact('cart'));
    }

    public function add($id)
    {
        $product = Product::findOrFail($id);

        $cart = Session::get('cart', []);
        $cart[$id] = [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => ($cart[$id]['quantity'] ?? 0) + 1,
            'image' => $product->image,
        ];

        Session::put('cart', $cart);

        return redirect()->back()->with('success', 'Đã thêm vào giỏ hàng!');
    }

    public function remove($id)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            Session::put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Đã xóa sản phẩm khỏi giỏ!');
    }
}
