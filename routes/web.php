<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\WishlistController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/',[FrontendController::class, 'index'])->name('frontend.index');
Route::get('/collections',[FrontendController::class, 'categories'])->name('frontend.categories');
Route::get('/collections/{category_slug}',[FrontendController::class, 'products'])->name('frontend.products');
Route::get('/collections/{category_slug}/{product_slug}',[FrontendController::class, 'productView'])->name('frontend.productView');
Route::get('wishlist',[WishlistController::class, 'index'])->name('wishlist.index');


Route::middleware(['auth'])->group(function(){
    Route::get('cart',[CartController::class,'index'])->name('cart.index');
    Route::get('wishlist',[WishlistController::class, 'index'])->name('wishlist.index');
    Route::get('checkout',[CheckoutController::class, 'index'])->name('checkout.index');
});

Route::get('thank-you',[FrontendController::class, 'thankYou'])->name('frontend.thankYou');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('admin')->middleware(['auth','isAdmin'])->group(function(){
    Route::get('dashboard',[App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::controller(SliderController::class)->group(function(){
        Route::get('sliders','index')->name('sliders.index');
        Route::get('sliders/create','create')->name('sliders.create');
        Route::post('sliders/create','store')->name('sliders.store');
        Route::get('sliders/{slider}/edit','edit')->name('sliders.update');
        Route::put('sliders/{slider}','update')->name('sliders.update');
        Route::get('sliders/{slider}/delete','destroy')->name('sliders.destroy');

    });

    //Category Routes
    Route::controller(CategoryController::class)->group(function(){
        Route::get('/category','index')->name('category.index');
        Route::get('/category/create','create')->name('category.create');
        Route::post('/category','store')->name('category.store');
        Route::get('/category/{category}/edit','edit')->name('category.edit');
        Route::put('category/{category}','update')->name('category.update');
    });
    Route::controller(ProductController::class)->group(function(){

        Route::get('/products','index')->name('products.index');
        Route::get('/products/create','create')->name('products.create');
        Route::post('products','store')->name('products.store');
        Route::get('products/{product}/edit','edit')->name('products.edit');
        Route::put('/products/{product}','update')->name('products.update');
        Route::get('products/{product_id}/delete','destroy')->name('products.destroy');
        Route::get('product-image/{product_image_id}/delete','destroyImage')->name('product-image.destroyImage');

        Route::post('product-color/{prod_color_id}','updateProdColorQty')->name('product-color.updateProdColorQty');
        Route::get('product-color/{prod_color_id}/delete','deleteProdColor')->name('product-color.deleteProdColor');

    });

    Route::get('/brands',App\Http\Livewire\Admin\Brand\Index::class)->name('brands.index');

    Route::controller(ColorController::class)->group(function(){
        Route::get('/colors','index')->name('colors.index');
        Route::get('/colors/create','create')->name('colors.create');
        Route::post('colors/create','store')->name('colors.store');
        Route::get('/colors/{color}/edit','edit')->name('colors.edit');
        Route::put('/colors/{color}','update')->name('colors.update');
        Route::get('/colors/{color_id}/delete','destroy')->name('colors.destroy');
    });
});
