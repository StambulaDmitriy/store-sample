<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreController;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [\App\Http\Controllers\IndexPageController::class,'index'])->name('index');
Route::get('products/{id}', [\App\Http\Controllers\IndexPageController::class,'show_product'])->name('show-product');



require __DIR__.'/auth.php';

Route::prefix('admin')->middleware('auth')->as('admin.')->group(function () {
    Route::get('/', [\App\Http\Controllers\ProfileController::class,'dashboard_index'])->name('dashboard');

    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::put('update-settings', [\App\Http\Controllers\ProfileController::class, 'update_settings'])->name('profile.update-settings');

    Route::resource('products', ProductController::class)->except(['show']);
    Route::get('products/export', [ProductController::class,'export'])->name('products.export');
    Route::resource('stores', StoreController::class);

});
