<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Address;

class OrderController extends Controller
{
    // Danh sách đơn hàng
    public function index()
    {
        $orders = Order::with(['customer', 'address'])->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    // Xem chi tiết đơn hàng
    public function show($id)
    {
        $order = Order::with(['customer', 'address', 'details.product'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    // Form thêm đơn hàng
    public function create()
    {
        $customers = User::where('usertype', 'user')->get();
        $addresses = Address::all();
        return view('admin.orders.create', compact('customers', 'addresses'));
    }

    // Lưu đơn hàng mới
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:users,id',
            'address_id' => 'required|exists:addresses,id',
        ]);

        Order::create([
            'customer_id' => $request->customer_id,
            'address_id' => $request->address_id,
            'status' => 'pending',
            'totalMoney' => 0,
        ]);

        return redirect()->route('admin.orders.index')->with('success', 'Thêm đơn hàng thành công');
    }

    // Form chỉnh sửa trạng thái đơn hàng
    public function edit($id)
    {
        $order = Order::with(['customer', 'address'])->findOrFail($id);
        $statuses = ['pending', 'confirmed', 'shipping', 'completed', 'cancelled'];
        return view('admin.orders.edit', compact('order', 'statuses'));
    }

    // Cập nhật trạng thái đơn hàng
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,confirmed,shipping,completed,cancelled'
        ]);

        $order->update(['status' => $request->status]);

        return redirect()->route('admin.orders.index')->with('success', 'Cập nhật trạng thái đơn hàng thành công');
    }

    // Xóa đơn hàng
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Xóa đơn hàng thành công');
    }
}
