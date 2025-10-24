<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Product;

class CartController extends Controller
{
    // Hiển thị giỏ hàng
    public function index()
    {
        $user = Auth::user();
        $cartItems = Cart::with('product')
                        ->where('user_id', $user->id)
                        ->get();

        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('user.cart.index', compact('cartItems', 'total'));
    }

    // Thêm sản phẩm vào giỏ
    public function add(Request $request, $id)
    {
        $user = Auth::user();
        $product = Product::findOrFail($id);

        $cartItem = Cart::firstOrCreate(
            ['user_id' => $user->id, 'product_id' => $id],
            ['quantity' => 0]
        );

        $cartItem->quantity += $request->input('quantity', 1);
        $cartItem->save();

        return redirect()->back()->with('success', 'Added to cart!');
    }

    // Xóa khỏi giỏ hàng
    public function remove($id)
    {
        $user = Auth::user();
        Cart::where('user_id', $user->id)
            ->where('id', $id)
            ->delete();

        return redirect()->back()->with('success', 'Item removed from cart.');
    }
}
