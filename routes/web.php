<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

// Serve storage files when symlink doesn't work (e.g. shared hosting / cPanel)
Route::match(['get', 'head'], 'storage/{path}', function () {
    $requestPath = ltrim(request()->path(), '/');
    if (!str_starts_with($requestPath, 'storage/')) {
        abort(404);
    }
    $path = substr($requestPath, 8); // strip 'storage/'
    if (empty($path) || str_contains($path, '..')) {
        abort(404);
    }

    $fullPath = storage_path('app/public/' . $path);
    $realPath = realpath($fullPath);
    $storageRoot = realpath(storage_path('app/public'));

    if (!$realPath || !is_file($realPath)) {
        abort(404);
    }
    if ($storageRoot && !Str::startsWith($realPath, $storageRoot)) {
        abort(404);
    }

    return response()->file($realPath);
})->where('path', '.*')->name('storage.serve');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/shop', [\App\Http\Controllers\ShopController::class, 'index'])->name('shop');
Route::get('/mobile-phones', [\App\Http\Controllers\MobilePhonesController::class, 'index'])->name('mobile-phones');
Route::get('/headsets', [\App\Http\Controllers\CategoryController::class, 'headsets'])->name('headsets');
Route::get('/accessories', [\App\Http\Controllers\CategoryController::class, 'accessories'])->name('accessories');
Route::get('/smart-watches', [\App\Http\Controllers\CategoryController::class, 'smartWatches'])->name('smart-watches');
Route::get('/offers', [\App\Http\Controllers\OffersController::class, 'index'])->name('offers');
Route::get('/blog', [\App\Http\Controllers\BlogController::class, 'index'])->name('blog');
Route::get('/contact', [\App\Http\Controllers\ContactController::class, 'show'])->name('contact');
Route::post('/contact', [\App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');
Route::get('/cart', [\App\Http\Controllers\CartController::class, 'index'])->name('cart');
Route::middleware('member.guest')->group(function () {
    Route::get('/login', [\App\Http\Controllers\AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [\App\Http\Controllers\AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register'])->name('register.store');
    Route::get('/forgot-password', [\App\Http\Controllers\AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [\App\Http\Controllers\AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [\App\Http\Controllers\AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password', [\App\Http\Controllers\AuthController::class, 'resetPassword'])->name('password.update');
});

Route::middleware('member')->group(function () {
    Route::get('/account', [\App\Http\Controllers\AuthController::class, 'account'])->name('account');
    Route::post('/account/profile', [\App\Http\Controllers\AuthController::class, 'updateProfile'])->name('account.profile');
    Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
});
Route::get('/product/{id}', [\App\Http\Controllers\ProductController::class, 'show'])->whereNumber('id')->name('product.show');
