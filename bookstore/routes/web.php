<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderDetailController;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
// User route 
Route::middleware(['auth', 'userMiddleware'])->group(function(){
    Route::get('dashboard',[UserController::class, 'index'])->name('dashboard');
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);

    // Quản lý đơn hàng (Admin xem và cập nhật trạng thái)
    Route::resource('orders', OrderController::class)->only(['index', 'show', 'update']);
});
// Admin route
Route::middleware(['auth', 'adminMiddleware']) -> group(function(){
    Route::get('/admin/dashboard',[AdminController::class, 'index' ] ) ->name('admin.dashboard');
    
    // User thêm địa chỉ
    Route::resource('addresses', AddressController::class)->only(['index','create','store','edit','update','destroy']);

    // User đặt hàng
    Route::resource('orders', OrderController::class)->only(['create','store','index','show']);

});