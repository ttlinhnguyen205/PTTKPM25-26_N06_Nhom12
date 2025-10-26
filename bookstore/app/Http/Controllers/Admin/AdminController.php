<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        // ===== THỐNG KÊ CƠ BẢN =====
        $totalProducts   = Product::count(); 
        $totalCategories = Category::count(); 
        $totalOrders     = Order::count(); 
        $totalClients    = User::where('usertype', 'user')->count(); 

        // ===== LẤY 5 ĐƠN HÀNG MỚI NHẤT =====
        $recentOrders = Order::with(['customer', 'address'])
            ->latest()
            ->take(5)
            ->get();

        // Tổng tiền của 5 đơn hàng gần nhất
        $recentOrdersTotal = $recentOrders->sum('total_money');

        // ===== DOANH THU THEO THÁNG =====
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

        // Dữ liệu cho biểu đồ và tổng kết
        $months = $revenues->pluck('month');  // Mảng các tháng
        $totals = $revenues->pluck('total');  // Mảng tổng tiền theo tháng
        $totalYear = $revenues->sum('total'); // Tổng doanh thu cả năm

        // ===== TOP 5 SẢN PHẨM BÁN CHẠY TRONG THÁNG HIỆN TẠI =====
        $currentMonth = Carbon::now()->month;
        $currentYear  = Carbon::now()->year;

        $topProducts = Product::select('products.id', 'products.name', 'products.price', DB::raw('SUM(order_details.quantity) as total_sold'))
            ->join('order_details', 'products.id', '=', 'order_details.product_id')
            ->join('orders', 'orders.id', '=', 'order_details.order_id')
            ->whereYear('orders.order_date', $currentYear)
            ->whereMonth('orders.order_date', $currentMonth)
            ->whereIn('orders.status', ['completed', 'paid', 'done'])
            ->groupBy('products.id', 'products.name', 'products.price')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        // ===== TRẢ DỮ LIỆU RA VIEW =====
        return view('admin.dashboard', compact(
            'totalProducts', 
            'totalCategories', 
            'totalOrders', 
            'totalClients',
            'recentOrders',
            'recentOrdersTotal',
            'revenues',
            'months',
            'totals',
            'totalYear',
            'year',
            'topProducts'
        ));
    }
}
