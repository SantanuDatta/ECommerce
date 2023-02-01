<?php

use Illuminate\Support\Facades\Route;
//Frontend
use App\Http\Controllers\Frontend\FrontPagesController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\ProductReviewController;

//Backend
use App\Http\Controllers\Backend\PagesController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\CountryController;
use App\Http\Controllers\Backend\DivisionController;
use App\Http\Controllers\Backend\DistrictController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\FlashController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Backend\CustomerController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\SslCommerzPaymentController;

/*
|--------------------------------------------------------------------------
| Front End Web Routes
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

//Home
Route::get('/', [FrontPagesController::class, 'home'])->name('home');
Route::get('/404', [FrontPagesController::class, 'notFound'])->name('notFound');

//User Dashboard
Route::group(['middleware' => ['auth', 'verified']], function(){
    Route::group(['prefix' => '/user'], function(){
        Route::get('/dashboard', [FrontPagesController::class, 'userDashboard'])->name('user.dashboard');
        Route::post('/update/{id}', [FrontPagesController::class, 'userUpdate'])->name('user.update');
        //User Account
        Route::get('/invoice/{inv_id}', [FrontPagesController::class, 'invoice'])->name('invoice');
        //Product Review
        Route::post('/review-product', [ProductReviewController::class, 'store'])->name('product.review');
        Route::post('/update-review-product/{id}', [ProductReviewController::class, 'update'])->name('update.review');
    });

    //Checkout Payment
    Route::post('/checkout/pay', [SslCommerzPaymentController::class, 'index'])->name('make.payment');

});

//Wishlist
Route::group(['prefix' => '/wishlist'], function(){
    Route::get('/', [WishlistController::class, 'index'])->name('wishlist.manage');
    Route::post('/edit/{id}', [WishlistController::class, 'edit'])->name('wishlist.edit');
    Route::post('/destroy/{id}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');
});

//Cart
Route::group(['prefix' => '/cart'], function(){
    Route::get('/', [CartController::class, 'index'])->name('cart.manage');
    Route::post('/store', [CartController::class, 'store'])->name('cart.store');
    Route::post('/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/destroy/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
});

//Checkout
Route::get('/checkout', [FrontPagesController::class, 'checkout'])->name('checkout');

//Search Products
Route::any('/search-products', [FrontPagesController::class, 'searchProduct'])->name('search.products');

//Products
Route::get('/shop', [FrontPagesController::class, 'shop'])->name('shop');
Route::get('/single-product/{slug}', [FrontPagesController::class, 'singleProduct'])->name('singleProduct');
Route::get('/category/{slug}', [FrontPagesController::class, 'categoryProduct'])->name('category.product');

//User Auth
Route::get('/customer-login', [FrontPagesController::class, 'customerLogin'])->name('customerLogin');

//Static Pages
Route::get('/about', [FrontPagesController::class, 'about'])->name('about');
Route::get('/contact', [FrontPagesController::class, 'contact'])->name('contact');
Route::post('/contact', [FrontPagesController::class, 'contactData'])->name('contact.data');
Route::get('/faq', [FrontPagesController::class, 'faq'])->name('faq');
Route::get('/privacy-policy', [FrontPagesController::class, 'privacyPolicy'])->name('privacyPolicy');
Route::get('/return-policy', [FrontPagesController::class, 'returnPolicy'])->name('returnPolicy');
Route::get('/terms-conditions', [FrontPagesController::class, 'termsCondition'])->name('termsCondition');

// SSLCOMMERZ Start
Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);
Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ END


/*
|--------------------------------------------------------------------------
| Back End Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => '/admin'], function(){
    Route::get('/dashboard', [PagesController::class, 'index'])->name('admin.dashboard');

    // Brand Route
    Route::group(['prefix' => '/brand'], function () {
        Route::get('/manage', [BrandController::class, 'index'])->name('brand.manage');
        Route::get('/create', [BrandController::class, 'create'])->name('brand.create');
        Route::post('/store', [BrandController::class, 'store'])->name('brand.store');
        Route::get('/edit/{id}', [BrandController::class, 'edit'])->name('brand.edit');
        Route::post('/update/{id}', [BrandController::class, 'update'])->name('brand.update');
        Route::post('/destroy/{id}', [BrandController::class, 'destroy'])->name('brand.destroy');
        Route::get('/softdelete', [BrandController::class, 'softDelete'])->name('brand.softdelete');
        Route::post('/delete/{id}', [BrandController::class, 'fullDelete'])->name('brand.fulldelete');
    });

    // Category Route
    Route::group(['prefix' => '/category'], function () {
        Route::get('/manage', [CategoryController::class, 'index'])->name('category.manage');
        Route::get('/create', [CategoryController::class, 'create'])->name('category.create');
        Route::post('/store', [CategoryController::class, 'store'])->name('category.store');
        Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
        Route::post('/update/{id}', [CategoryController::class, 'update'])->name('category.update');
        Route::post('/destroy/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');
        Route::get('/softdelete', [CategoryController::class, 'softDelete'])->name('category.softdelete');
        Route::post('/delete/{id}', [CategoryController::class, 'fullDelete'])->name('category.fulldelete');
    });

    // Product Route
    Route::group(['prefix' => '/product'], function () {
        Route::get('/manage', [ProductController::class, 'index'])->name('product.manage');
        Route::get('/create', [ProductController::class, 'create'])->name('product.create');
        Route::post('/store', [ProductController::class, 'store'])->name('product.store');
        Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
        Route::post('/update/{id}', [ProductController::class, 'update'])->name('product.update');
        Route::post('/destroy/{id}', [ProductController::class, 'destroy'])->name('product.destroy');
        Route::get('/softdelete', [ProductController::class, 'softDelete'])->name('product.softdelete');
        Route::post('/delete/{id}', [ProductController::class, 'fullDelete'])->name('product.fulldelete');
    });

    // Order Route
    Route::group(['prefix' => '/all-orders'], function(){
        Route::get('/manage', [OrderController::class, 'index'])->name('order.manage');
        Route::get('/order-details/{id}', [OrderController::class, 'show'])->name('order.details');
        Route::post('/order-details/update/{id}', [OrderController::class, 'update'])->name('order.update');
        Route::post('/destroy/{id}', [OrderController::class, 'destroy'])->name('order.destroy');
    });

    // Country Route
    Route::group(['prefix' => '/country'], function () {
        Route::get('/manage', [CountryController::class, 'index'])->name('country.manage');
        Route::get('/create', [CountryController::class, 'create'])->name('country.create');
        Route::post('/store', [CountryController::class, 'store'])->name('country.store');
        Route::get('/edit/{id}', [CountryController::class, 'edit'])->name('country.edit');
        Route::post('/update/{id}', [CountryController::class, 'update'])->name('country.update');
        Route::post('/destroy/{id}', [CountryController::class, 'destroy'])->name('country.destroy');
    });

    // Division Route
    Route::group(['prefix' => '/division'], function () {
        Route::get('/manage', [DivisionController::class, 'index'])->name('division.manage');
        Route::get('/create', [DivisionController::class, 'create'])->name('division.create');
        Route::post('/store', [DivisionController::class, 'store'])->name('division.store');
        Route::get('/edit/{id}', [DivisionController::class, 'edit'])->name('division.edit');
        Route::post('/update/{id}', [DivisionController::class, 'update'])->name('division.update');
        Route::post('/destroy/{id}', [DivisionController::class, 'destroy'])->name('division.destroy');
    });

    // District Route
    Route::group(['prefix' => '/district'], function () {
        Route::get('/manage', [DistrictController::class, 'index'])->name('district.manage');
        Route::get('/create', [DistrictController::class, 'create'])->name('district.create');
        Route::post('/store', [DistrictController::class, 'store'])->name('district.store');
        Route::get('/edit/{id}', [DistrictController::class, 'edit'])->name('district.edit');
        Route::post('/update/{id}', [DistrictController::class, 'update'])->name('district.update');
        Route::post('/destroy/{id}', [DistrictController::class, 'destroy'])->name('district.destroy');
    });

    // Customer Route
    Route::group(['prefix' => '/customer'], function (){
        Route::get('/manage', [CustomerController::class, 'index'])->name('customer.manage');
    });

    // Setting Route
    Route::group(['prefix' => '/setting'], function () {
        Route::get('/manage', [SettingController::class, 'index'])->name('setting.manage');
        Route::post('/update/{id}', [SettingController::class, 'update'])->name('setting.update');
    });

    // Slider Route
    Route::group(['prefix' => '/slider'], function () {
        Route::get('/manage', [SliderController::class, 'index'])->name('slider.manage');
        Route::get('/create', [SliderController::class, 'create'])->name('slider.create');
        Route::post('/store', [SliderController::class, 'store'])->name('slider.store');
        Route::get('/edit/{id}', [SliderController::class, 'edit'])->name('slider.edit');
        Route::post('/update/{id}', [SliderController::class, 'update'])->name('slider.update');
        Route::post('/destroy/{id}', [SliderController::class, 'destroy'])->name('slider.destroy');
    });

    // Flash Route
    Route::group(['prefix' => '/flash'], function () {
        Route::get('/manage', [FlashController::class, 'index'])->name('flash.manage');
        Route::get('/create', [FlashController::class, 'create'])->name('flash.create');
        Route::post('/store', [FlashController::class, 'store'])->name('flash.store');
        Route::get('/edit/{id}', [FlashController::class, 'edit'])->name('flash.edit');
        Route::post('/update/{id}', [FlashController::class, 'update'])->name('flash.update');
        Route::post('/destroy/{id}', [FlashController::class, 'destroy'])->name('flash.destroy');
    });

});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/api.php';
require __DIR__.'/auth.php';
