<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\CartController;

use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\ProductController as UserProductController; 

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;

use App\Http\Controllers\AddressController;
use App\Http\Controllers\OrderDetailController;



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

Route::middleware(['auth', 'userMiddleware'])
    ->prefix('user')   
    ->name('user.')
    ->group(function(){
        Route::get('/dashboard',[UserController::class, 'index'])->name('dashboard');
        Route::resource('categories', CategoryController::class);
        Route::get('/products/{id}', [UserProductController::class, 'show'])->name('products.show');
               
        Route::post('/cart/{id}', [CartController::class, 'add'])->name('cart.add');
        Route::delete('/cart/{id}', [CartController::class, 'remove'])->name('cart.remove');
        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');


        Route::get('/checkout/{id}', [CheckoutController::class, 'show'])->name('checkout.show');
        Route::post('/checkout/{id}', [CheckoutController::class, 'process'])->name('checkout.process');
        
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
        Route::resource('products', AdminProductController::class);
        Route::resource('orders', \App\Http\Controllers\Admin\OrderController::class);
    });

