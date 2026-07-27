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
Route::get('/product/{id}', [\App\Http\Controllers\ProductController::class, 'show'])->whereNumber('id')->name('product.show');
