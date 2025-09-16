<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\OrderDetailController;
use App\Http\Controllers\Admin\ProductController;

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
});
// Admin route
Route::middleware(['auth', 'adminMiddleware'])
    ->prefix('admin')   
    ->name('admin.')   
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

        // Resource routes
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
        Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
        Route::resource('orders', \App\Http\Controllers\Admin\OrderController::class);
    });

