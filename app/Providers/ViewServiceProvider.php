<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Http\View\Composers\FlashComposer;
use App\Http\View\Composers\SettingComposer;
use App\Http\View\Composers\CategoryComposer;
class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', SettingComposer::class);
        View::composer(
            ['frontend.pages.homepage', 'frontend.pages.404', 'frontend.pages.userDashboard.invoice', 'frontend.pages.userDashboard.user-account', 'frontend.pages.products.searchProducts', 'frontend.pages.products.shop', 'frontend.pages.products.singleProduct', 'frontend.pages.userAuth.login', 'frontend.pages.checkout', 'frontend.pages.cart', 'frontend.pages.staticPages.about', 'frontend.pages.staticPages.contact', 'frontend.pages.staticPages.faqs', 'frontend.pages.staticPages.privacy-policy', 'frontend.pages.staticPages.return-policy', 'frontend.pages.staticPages.terms-conditions', 'frontend.pages.userAuth.confirm-password', 'frontend.pages.userAuth.verify-email', 'frontend.pages.userAuth.reset-password','frontend.pages.userAuth.forgot-password', 'frontend.pages.userAuth.register', 'frontend.pages.success', 'frontend.pages.products.categoryProduct', 'frontend.pages.wishlist'], 
            FlashComposer::class
        );
        View::composer(
            ['frontend.pages.homepage', 'frontend.pages.404', 'frontend.pages.userDashboard.invoice', 'frontend.pages.userDashboard.user-account', 'frontend.pages.products.searchProducts', 'frontend.pages.products.shop', 'frontend.pages.cart', 'frontend.pages.products.singleProduct', 'frontend.pages.userAuth.login', 'frontend.pages.checkout', 'frontend.pages.staticPages.about', 'frontend.pages.staticPages.contact', 'frontend.pages.staticPages.faqs', 'frontend.pages.staticPages.privacy-policy', 'frontend.pages.staticPages.return-policy', 'frontend.pages.staticPages.terms-conditions', 'frontend.pages.userAuth.confirm-password', 'frontend.pages.userAuth.verify-email', 'frontend.pages.userAuth.reset-password','frontend.pages.userAuth.forgot-password', 'frontend.pages.userAuth.register', 'frontend.pages.success', 'frontend.pages.products.categoryProduct', 'frontend.pages.wishlist'], 
            CategoryComposer::class
        );
    }
}
