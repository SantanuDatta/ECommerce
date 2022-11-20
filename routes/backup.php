<?php

use Illuminate\Support\Facades\Route;
//Frontend
use App\Http\Controllers\Frontend\FrontPagesController;

//Backend
use App\Http\Controllers\Backend\PagesController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\CountryController;
use App\Http\Controllers\Backend\DivisionController;
use App\Http\Controllers\Backend\DistrictController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\FlashController;
use Illuminate\Routing\RouteGroup;

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

Route::get('/', [FrontPagesController::class, 'home'])->name('home');
Route::get('/404', [FrontPagesController::class, 'notFound'])->name('notFound');
Route::get('/cart', [FrontPagesController::class, 'cart'])->name('cart');
Route::get('/checkout', [FrontPagesController::class, 'checkout'])->name('checkout');

//User Account
Route::get('/invoice', [FrontPagesController::class, 'invoice'])->name('invoice');
Route::get('/user-account', [FrontPagesController::class, 'userAccount'])->name('userAccount');

//Search Products
Route::post('/search-products', [FrontPagesController::class, 'searchProduct'])->name('search.products');

//Products 
Route::get('/shop', [FrontPagesController::class, 'shop'])->name('shop');
Route::get('/single-product/{slug}', [FrontPagesController::class, 'singleProduct'])->name('singleProduct');

//User Auth 
Route::get('/login', [FrontPagesController::class, 'login'])->name('login');
Route::get('/register', [FrontPagesController::class, 'register'])->name('register');
Route::get('/forgot-password', [FrontPagesController::class, 'forgotPassword'])->name('forgotPassword');
Route::get('/reset-password', [FrontPagesController::class, 'resetPassword'])->name('resetPassword');

//Static Pages
Route::get('/about', [FrontPagesController::class, 'about'])->name('about');
Route::get('/contact', [FrontPagesController::class, 'contact'])->name('contact');
Route::get('/faq', [FrontPagesController::class, 'faq'])->name('faq');
Route::get('/privacy-policy', [FrontPagesController::class, 'privacyPolicy'])->name('privacyPolicy');
Route::get('/return-policy', [FrontPagesController::class, 'returnPolicy'])->name('returnPolicy');
Route::get('/terms-conditions', [FrontPagesController::class, 'termsCondition'])->name('termsCondition');


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
