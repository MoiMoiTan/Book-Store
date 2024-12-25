<?php
use Illuminate\Support\Facades\Route;
// Import controllers
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportController;
// Trang chủ welcome
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
// Đăng ký và đăng nhập người dùng
Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
// Route dành cho admin (sử dụng middleware để kiểm tra quyền)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    // Route quản lý sản phẩm
    Route::resource('/admin/products', ProductController::class, [
        'as' => 'admin' // Đặt tiền tố 'admin' cho tất cả các route của products
    ]);
    // Route quản lý danh mục
    Route::resource('/admin/categories', CategoryController::class, [
        'as' => 'admin' // Đặt tiền tố 'admin' cho tất cả các route của categories
    ]);
    Route::get('/admin/orders', [OrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/admin/orders/{order}', [OrderController::class, 'show'])->name('admin.orders.show');
    Route::patch('/admin/orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('admin.orders.update-status');
    Route::get('/admin/orders/{order}/print-invoice', [OrderController::class, 'printInvoice'])->name('admin.orders.print-invoice');
    Route::delete('/admin/orders/{order}', [OrderController::class, 'destroy'])->name('admin.orders.destroy');
    Route::get('/admin/reports', [ReportController::class, 'index'])->name('admin.reports.index');
});
// Route cho người dùng bình thường
Route::middleware(['auth'])->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{product}', [ProductController::class, 'show_normal'])->name('products.show');
    Route::middleware(['auth'])->group(function () {
        Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
        Route::delete('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
        Route::patch('/cart/update/{product}', [CartController::class, 'update'])->name('cart.update');
        Route::patch('/cart/update-all', [CartController::class, 'updateAll'])->name('cart.updateAll');
        Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
        Route::get('/cart/checkout/{order}', [CartController::class, 'checkout'])->name('cart.checkout');
    });
});
Route::post('/cart/print-invoice', [CartController::class, 'printInvoice'])->name('cart.printInvoice');
Route::post('/cart/process', [CartController::class, 'process'])->name('cart.process');
Route::get('/search', [App\Http\Controllers\ProductController::class, 'search'])->name('search');
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');