<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\OrderDetailsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/




Route::get('/register', function () {
    return view('User/register');
})->name('register');

Route::get('/login', function () {
    return view('User/login');
})->name('login');









Route::get('/DashBoard', [ProductController::class, 'index'])->name('admin');
Route::get('/DashBoard/{id}', [ProductController::class, 'showForAdmin'])->name('admin.info');
Route::get('/', [ProductController::class, 'getProducts'])->name('home');
Route::post('/', [ProductController::class, 'search'])->name('search');

Route::delete('DashBoard/delete-product', [ProductController::class, 'destroy'])->name('product.delete');
Route::post('DashBoard/add-product', [ProductController::class, 'store'])->name('product.add');
Route::put('DashBoard/edit-product', [ProductController::class, 'update'])->name('product.update');




Route::post('/login', [UserController::class, 'login'])->name('login.post');
Route::post('/register', [UserController::class, 'register'])->name('register.post');
Route::post('/logout', [UserController::class, 'logout'])->name('logout')->middleware(\App\Http\Middleware\NoCacheMiddleware::class);
Route::get('/profile/{id}', [UserController::class, 'show'])->name('profile.show');
Route::put('/profile/{id}/update', [UserController::class, 'update'])->name('profile.update');


Route::get('/cart', [CartController::class, 'index'])->name('cart.show');
Route::post('/cart/add', [CartController::class, 'addItem'])->name('cart.add');
Route::post('/cart/update/{cartItemId}', [CartController::class, 'updateItemQuantity'])->name('cart.update');
Route::post('/cart/remove/{cartItemId}', [CartController::class, 'removeItem'])->name('cart.remove');

Route::post('/order', [OrdersController::class, 'store'])->name('submitOrder');

Route::get('/order/{id}/details', [OrderDetailsController::class, 'show'])->name('details.show');

