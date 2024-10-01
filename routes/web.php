<?php

use App\Http\Controllers\Api;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

});

Route::group([
    'prefix' => 'v1',
], function () {
    Route::get('orders', [Api::class, 'orders'])->name('get-orders');

    Route::prefix('reports')->group(function () {
        Route::get('/getProductCountFromOrderStatus', [ReportsController::class, 'getProductCountFromOrderStatus']);
        Route::get('/getMostOrderedProductAndNotInStockOfYear', [ReportsController::class, 'getMostOrderedProductAndNotInStockOfYear']);
    });

    // TODO 4 fonksiyon implement edilecek. Gerekli yerlerde Request/Resource class'ları üstteki endpointteki şekliyle kullanılmalıdır.

    // Eğer Methot get olmayacaksa kısa yoldan erişim için resource kullanılabilir. 
    // Bununla birlikte modul isimleri standart olarak coğul yazılması önerilir.
    // Eğer Model binding yapılacaksa direk idden bağımsız isimlendirme yapmak daha doğru olacaktır. 
    // Model isimleri de laravel standartlarına göre tekil olması önerilir.
    // Extradan Api Class get içerisinde yazılması düzeltmedir diye düşünerek ProductController içerisinde çözümleyeceğim.
    // Route::resource("products")
    
    Route::prefix('product')->group(function () {
        Route::get('/{product}', [ProductController::class, 'get'])->name('get-product');
        Route::post('/', [ProductController::class, 'store'])->name('create-product');
        Route::put('/{product}', [ProductController::class, 'update'])->name('update-product');
        Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy-product');
    });
});