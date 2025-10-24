<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;

class AdminController extends Controller
{
    public function index()
    {
        // Tổng số lượng thống kê
        $totalProducts   = Product::count(); 
        $totalCategories = Category::count(); 
        $totalOrders     = Order::count(); 

        // Lấy 5 đơn hàng mới nhất (kèm thông tin người dùng + địa chỉ)
        $recentOrders = Order::with(['customer', 'address'])
            ->latest()
            ->take(5)
            ->get();

        // Tổng tiền 5 đơn hàng mới
        $recentOrdersTotal = $recentOrders->sum('total_money');

        // TÍNH DOANH THU THEO THÁNG

        $year = now()->year;

        $revenues = Order::selectRaw('MONTH(order_date) as month, SUM(total_money) as total')
            ->whereYear('order_date', $year)
            ->where(function($q){
                $q->where('status', 'completed')
                ->orWhere('status', 'paid')
                ->orWhere('status', 'done');
            })
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Dữ liệu cho Chart
        $months = $revenues->pluck('month');
        $totals = $revenues->pluck('total');
        $totalYear = $revenues->sum('total');

        return view('admin.dashboard', compact(
            'totalProducts', 
            'totalCategories', 
            'totalOrders', 
            'recentOrders',
            'recentOrdersTotal',
            'months',
            'totals',
            'totalYear',
            'year'
        ));
    }

}
