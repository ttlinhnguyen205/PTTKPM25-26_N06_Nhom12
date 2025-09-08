<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Address;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index() {
        $orders = Auth::user()->usertype === 'admin'
            ? Order::with('details')->get()
            : Order::where('customer_id', Auth::id())->with('details')->get();

        return view('orders.index', compact('orders'));
    }

    public function create() {
        $addresses = Auth::user()->addresses;
        return view('orders.create', compact('addresses'));
    }

    public function store(Request $request) {
        $request->validate([
            'address_id' => 'required|exists:addresses,id',
        ]);

        $order = Order::create([
            'customer_id' => Auth::id(),
            'address_id'  => $request->address_id,
            'totalMoney'  => 0,
        ]);

        return redirect()->route('orders.index')->with('success', 'Dat hang thanh cong');
    }

    public function show($id) {
        $order = Order::with('details.product')->findOrFail($id);
        return view('orders.show', compact('order'));
    }

    public function update(Request $request, $id) {
        $order = Order::findOrFail($id);

        if (Auth::user()->usertype === 'admin') {
            $order->update(['status' => $request->status]);
        }

        return redirect()->route('orders.index')->with('success', 'Cap nhat don hang thanh cong');
    }

    public function destroy($id) {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Xoa don hang thanh cong');
    }
}
