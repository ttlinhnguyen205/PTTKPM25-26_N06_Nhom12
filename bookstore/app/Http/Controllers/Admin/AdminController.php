<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;

class AdminController extends Controller
{
    public function index()
    {
        // Thống kê
        $totalProducts   = Product::count(); 
        $totalCategories = Category::count(); 
        $totalOrders     = Order::count(); 

        // 5 đơn hàng mới nhất cùng thông tin user và address
        $recentOrders = Order::with(['customer', 'address'])
                             ->latest()
                             ->take(5)
                             ->get();

        // Tính tổng tiền của 5 đơn hàng mới nhất 
        $recentOrdersTotal = $recentOrders->sum('total_money');

        return view('admin.dashboard', compact(
            'totalProducts', 
            'totalCategories', 
            'totalOrders', 
            'recentOrders',
            'recentOrdersTotal'
        ));
    }
}
