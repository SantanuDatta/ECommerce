    <header class="header-area header-style-1 header-height-2">
        {{-- <div class="mobile-promotion">
            <div class="text-center">
                <div id="news=flash" class="d-inline-block">
                    <ul>
                        @foreach ($flashes as $flash)
                            <li>{{ $flash->name }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div> --}}
        <div class="header-top header-top-ptb-1 d-none d-lg-block">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-3 col-lg-4">
                        <div class="header-info">
                            <ul>
                                <li><a href="{{ route('user.dashboard') }}">{{ __('My Account') }}</a></li>
                                <li><a href="shop-wishlist.html">Wishlist</a></li>
                                <li><a href="shop-order.html">Order Tracking</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-4">
                        <div class="text-center">
                            <div id="news-flash" class="d-inline-block">
                                <ul>
                                    @foreach ($flashes as $flash)
                                        <li>{{ $flash->name }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4">
                        <div class="header-info header-info-right">
                            <ul>
                                @foreach ($settings as $setting)
                                    <li>Need help? Call Us: <strong class="text-brand"> {{ $setting->phone_no ?? 'N/A'}}</strong></li>
                                @endforeach
                                <li>
                                    <a class="language-dropdown-active" href="#">English <i class="fi-rs-angle-small-down"></i></a>
                                    <ul class="language-dropdown">
                                        <li>
                                            <a href="#"><img src="{{ asset('frontend/assets/imgs/theme/flag-fr.png')  }}" alt="" />Français</a>
                                        </li>
                                        <li>
                                            <a href="#"><img src="{{ asset('frontend/assets/imgs/theme/flag-dt.png')  }}" alt="" />Deutsch</a>
                                        </li>
                                        <li>
                                            <a href="#"><img src="{{ asset('frontend/assets/imgs/theme/flag-ru.png')  }}" alt="" />Pусский</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a class="language-dropdown-active" href="#">USD <i class="fi-rs-angle-small-down"></i></a>
                                    <ul class="language-dropdown">
                                        <li>
                                            <a href="#"><img src="{{ asset('frontend/assets/imgs/theme/flag-fr.png')  }}" alt="" />INR</a>
                                        </li>
                                        <li>
                                            <a href="#"><img src="{{ asset('frontend/assets/imgs/theme/flag-dt.png')  }}" alt="" />MBP</a>
                                        </li>
                                        <li>
                                            <a href="#"><img src="{{ asset('frontend/assets/imgs/theme/flag-ru.png')  }}" alt="" />EU</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-middle header-middle-ptb-1 d-none d-lg-block">
            <div class="container">
                <div class="header-wrap">
                    <div class="logo logo-width-1">
                        @foreach ($settings as $setting)
                            <a href="{{ route('home') }}"><img src="{{ asset('backend/img/settings/logo/'. $setting->logo) }}" alt="logo" /></a>
                        @endforeach
                    </div>
                    <div class="header-right">
                        <div class="search-style-2">
                            <form action="{{ route('search.products') }}" method="POST">
                                @csrf
                                <select class="select-active">
                                    <option hidden>All Categories</option>
                                    @foreach ($categories as $category)
                                        <option>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <input type="text" name="searchContent" placeholder="Search for items..." />
                            </form>
                        </div>
                        <div class="header-action-right">
                            <div class="header-action-2">
                                {{-- <div class="search-location">
                                    <form action="#">
                                        <select class="select-active">
                                            <option>Your Location</option>
                                            <option>Alabama</option>
                                            <option>Alaska</option>
                                            <option>Arizona</option>
                                            <option>Delaware</option>
                                            <option>Florida</option>
                                            <option>Georgia</option>
                                            <option>Hawaii</option>
                                            <option>Indiana</option>
                                            <option>Maryland</option>
                                            <option>Nevada</option>
                                            <option>New Jersey</option>
                                            <option>New Mexico</option>
                                            <option>New York</option>
                                        </select>
                                    </form>
                                </div> --}}
                                <div class="header-action-icon-2">
                                    <a href="shop-compare.html">
                                        <img class="svgInject" alt="Nest" src="{{ asset('frontend/assets/imgs/theme/icons/icon-compare.svg')  }}" />
                                        <span class="pro-count blue">3</span>
                                    </a>
                                    <a href="shop-compare.html"><span class="lable ml-0">Compare</span></a>
                                </div>
                                @php
                                    $wishCount = DB::table('markable_favorites')->where('user_id', Auth::user()?->id)->get();
                                @endphp
                                <div class="header-action-icon-2">
                                    <a href="{{ route('wishlist.manage') }}">
                                        <img class="svgInject" alt="Nest" src="{{ asset('frontend/assets/imgs/theme/icons/icon-heart.svg')  }}" />
                                        <span class="pro-count blue">{{ $wishCount->count() }}</span>
                                    </a>
                                    <a href="{{ route('wishlist.manage') }}"><span class="lable">Wishlist</span></a>
                                </div>
                                {{-- Cart --}}
                                <div class="header-action-icon-2">
                                    <a class="mini-cart-icon" href="{{ route('cart.manage') }}">
                                        <img alt="Nest" src="{{ asset('frontend/assets/imgs/theme/icons/icon-cart.svg')  }}" />
                                        <span class="pro-count blue">{{ App\Models\Cart::totalItems() }}</span>
                                    </a>
                                    <a href="{{ route('cart.manage') }}"><span class="lable">{{ __('Cart') }}</span></a>
                                    <div class="cart-dropdown-wrap cart-dropdown-hm2">
                                        <ul>
                                            @php
                                                $totalAmount = 0;
                                            @endphp
                                            @if (App\Models\Cart::totalItems() == 0)
                                                <p class="text-center">{{ __('No Item Added To Your Cart!!') }}</p>
                                            @endif
                                            @foreach (App\Models\Cart::totalCarts() as $cart)
                                                <li>
                                                    <div class="shopping-cart-img">
                                                        <a href="{{ route('cart.manage') }}">
                                                        <a href="{{ route('cart.manage') }}">
                                                            @php $img = 1; @endphp
                                                            @if ($cart->product->images->count() > 0)
                                                                <img src="{{ asset('backend/img/products/' . $cart->product->images->first()->image) }}" alt="#" />
                                                            @endif
                                                        </a>
                                                    </div>
                                                    <div class="shopping-cart-title">
                                                        <h4><a href="{{ route('cart.manage') }}">{{ Str::limit($cart->product->name, 12) }}</a></h4>
                                                        <h4>
                                                            @if (!is_null($cart->product->offer_price))
                                                                @php
                                                                    $totalSave = ($cart->product->regular_price *($cart->product->offer_price /100) );
                                                                    $savedAmount = $cart->product->regular_price - $totalSave;
                                                                @endphp
                                                                <span>{{ $cart->product_quantity }} × {{ $savedAmount }}</span>
                                                            @else
                                                                <span>{{ $cart->product_quantity }} × {{ $cart->product->regular_price }}</span>
                                                            @endif
                                                            @if (!is_null($cart->product->offer_price))
                                                                @php
                                                                    $totalAmount += $savedAmount * $cart->product_quantity;
                                                                @endphp
                                                                {{ __('BDT') }}
                                                            @else
                                                            @php
                                                                $totalAmount += $cart->product->regular_price * $cart->product_quantity;
                                                            @endphp
                                                                {{ __('BDT') }}
                                                            @endif
                                                        </h4>
                                                    </div>
                                                    <div class="shopping-cart-delete">
                                                        <form action="{{ route('cart.destroy', $cart->id) }}" method="POST" class="cart-destroy">
                                                        @csrf
                                                            <button type="submit" class="cart-btn-destroy"><i class="fi-rs-cross-small"></i></button>
                                                        </form>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="shopping-cart-footer">
                                            <div class="shopping-cart-total">
                                                <h4>{{ __('Total') }} <span>{{ $totalAmount }} {{ __('BDT') }}</span></h4>
                                            </div>
                                            <div class="shopping-cart-button">
                                                <a href="{{ route('cart.manage') }}" class="outline">{{ __('View cart') }}</a>
                                                @if (App\Models\Cart::totalItems() == 0)
                                                <button type="button" class="btn" disabled>{{ __('Checkout') }}</button>
                                                @else
                                                    <a href="{{ route('checkout') }}">{{ __('Checkout') }}</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- User Account --}}
                                <div class="header-action-icon-2">
                                    @if (Auth::check())
                                        <img class="svgInject" alt="Nest" src="{{ asset('frontend/assets/imgs/theme/icons/icon-user.svg')  }}" style="margin-right: 5px";/>
                                        <span class="lable ml-0">{{ Auth::user()->name }} {{ Auth::user()->lastName }}</span>
                                        {{-- Account Dropdown --}}
                                        <div class="cart-dropdown-wrap cart-dropdown-hm2 account-dropdown">
                                            <ul>
                                                <li>
                                                    <a href="{{ route('user.dashboard') }}"><i class="fi fi-rs-user mr-10"></i>My Account</a>
                                                </li>
                                                <li>
                                                    <a href="page-account.html"><i class="fi fi-rs-location-alt mr-10"></i>Order Tracking</a>
                                                </li>
                                                <li>
                                                    <a href="page-account.html"><i class="fi fi-rs-label mr-10"></i>My Voucher</a>
                                                </li>
                                                <li>
                                                    <a href="shop-wishlist.html"><i class="fi fi-rs-heart mr-10"></i>My Wishlist</a>
                                                </li>
                                                <li>
                                                    <a href="page-account.html"><i class="fi fi-rs-settings-sliders mr-10"></i>Setting</a>
                                                </li>
                                                <li>
                                                    <form method="POST" action="{{ route('logout') }}">
                                                        @csrf
                                                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"><i class="fi fi-rs-sign-out mr-10"></i>{{ __('Log Out') }}</a>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                        @else
                                            <img class="svgInject" alt="Nest" src="{{ asset('frontend/assets/imgs/theme/icons/icon-user.svg')  }}" style="margin-right: 5px"; />
                                            <span class="lable ml-0"><a href="{{ route('customerLogin') }}">{{ __('Login') }}</a> / <a href="{{ route('register') }}">{{ __('Register') }}</a></span> 
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-bottom header-bottom-bg-color sticky-bar">
            <div class="container">
                <div class="header-wrap header-space-between position-relative">
                    <div class="logo logo-width-1 d-block d-lg-none">
                        @foreach ($settings as $setting)
                            <a href="{{ route('home') }}"><img src="{{ asset('backend/img/settings/logo/'. $setting->logo) }}" alt="logo" /></a>
                        @endforeach
                        
                    </div>
                    <div class="header-nav d-none d-lg-flex">
                        <div class="main-categori-wrap d-none d-lg-block">
                            <a class="categories-button-active" href="#">
                                <span class="fi-rs-apps"></span> <span class="et">Browse</span> All Categories
                                <i class="fi-rs-angle-down"></i>
                            </a>
                            <div class="categories-dropdown-wrap categories-dropdown-active-large font-heading">
                                <div class="d-flex categori-dropdown-inner">
                                    <ul>
                                        @foreach ($categories as $category)
                                            @if ($loop->odd)
                                                <li>
                                                    <a href="shop-grid-right.html"> <img src="{{ asset('frontend/assets/imgs/theme/icons/category-1.svg')  }}" alt="" />{{ $category->name }}</a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                    <ul class="end">
                                        @foreach ($categories as $category)
                                            @if ($loop->even)
                                                <li>
                                                    <a href="shop-grid-right.html"> <img src="{{ asset('frontend/assets/imgs/theme/icons/category-6.svg')  }}" alt="" />{{ $category->name }}</a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                                {{-- <div class="more_slide_open" style="display: none">
                                    <div class="d-flex categori-dropdown-inner">
                                        <ul>
                                            <li>
                                                <a href="shop-grid-right.html"> <img src="{{ asset('frontend/assets/imgs/theme/icons/icon-1.svg')  }}" alt="" />Milks and Dairies</a>
                                            </li>
                                        </ul>
                                        <ul class="end">
                                            <li>
                                                <a href="shop-grid-right.html"> <img src="{{ asset('frontend/assets/imgs/theme/icons/icon-3.svg')  }}" alt="" />Wines & Drinks</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="more_categories"><span class="icon"></span> <span class="heading-sm-1">Show more...</span></div> --}}
                            </div>
                        </div>
                        <div class="main-menu main-menu-padding-1 main-menu-lh-2 d-none d-lg-block font-heading">
                            <nav>
                                <ul>
                                    {{-- <li class="hot-deals"><img src="{{ asset('frontend/assets/imgs/theme/icons/icon-hot.svg')  }}" alt="hot deals" /><a href="shop-grid-right.html">Deals</a></li> --}}
                                    <li>
                                        <a class=" @if (Route::is('home')) active @endif " href="{{ route('home') }}">{{ __('Home') }}</a>
                                    </li>
                                    <li>
                                        <a class="@if (Route::is('shop') || Route::is('singleProduct')) active @endif" href="{{ route('shop') }}">{{ __('Shop') }}</a>
                                    </li>
                                    <li>
                                        <a class="@if (Route::is('about')) active @endif" href="{{ route('about') }}">{{ __('About Us') }}</a>
                                    </li>
                                    {{-- <li class="position-static">
                                        <a href="#">Mega menu <i class="fi-rs-angle-down"></i></a>
                                        <ul class="mega-menu">
                                            <li class="sub-mega-menu sub-mega-menu-width-22">
                                                <a class="menu-title" href="#">Fruit & Vegetables</a>
                                                <ul>
                                                    <li><a href="shop-product-right.html">Meat & Poultry</a></li>
                                                    <li><a href="shop-product-right.html">Fresh Vegetables</a></li>
                                                    <li><a href="shop-product-right.html">Herbs & Seasonings</a></li>
                                                    <li><a href="shop-product-right.html">Cuts & Sprouts</a></li>
                                                    <li><a href="shop-product-right.html">Exotic Fruits & Veggies</a></li>
                                                    <li><a href="shop-product-right.html">Packaged Produce</a></li>
                                                </ul>
                                            </li>
                                            <li class="sub-mega-menu sub-mega-menu-width-22">
                                                <a class="menu-title" href="#">Breakfast & Dairy</a>
                                                <ul>
                                                    <li><a href="shop-product-right.html">Milk & Flavoured Milk</a></li>
                                                    <li><a href="shop-product-right.html">Butter and Margarine</a></li>
                                                    <li><a href="shop-product-right.html">Eggs Substitutes</a></li>
                                                    <li><a href="shop-product-right.html">Marmalades</a></li>
                                                    <li><a href="shop-product-right.html">Sour Cream</a></li>
                                                    <li><a href="shop-product-right.html">Cheese</a></li>
                                                </ul>
                                            </li>
                                            <li class="sub-mega-menu sub-mega-menu-width-22">
                                                <a class="menu-title" href="#">Meat & Seafood</a>
                                                <ul>
                                                    <li><a href="shop-product-right.html">Breakfast Sausage</a></li>
                                                    <li><a href="shop-product-right.html">Dinner Sausage</a></li>
                                                    <li><a href="shop-product-right.html">Chicken</a></li>
                                                    <li><a href="shop-product-right.html">Sliced Deli Meat</a></li>
                                                    <li><a href="shop-product-right.html">Wild Caught Fillets</a></li>
                                                    <li><a href="shop-product-right.html">Crab and Shellfish</a></li>
                                                </ul>
                                            </li>
                                            <li class="sub-mega-menu sub-mega-menu-width-34">
                                                <div class="menu-banner-wrap">
                                                    <a href="shop-product-right.html"><img src="{{ asset('frontend/assets/imgs/banner/banner-menu.png')  }}" alt="Nest" /></a>
                                                    <div class="menu-banner-content">
                                                        <h4>Hot deals</h4>
                                                        <h3>
                                                            Don't miss<br />
                                                            Trending
                                                        </h3>
                                                        <div class="menu-banner-price">
                                                            <span class="new-price text-success">Save to 50%</span>
                                                        </div>
                                                        <div class="menu-banner-btn">
                                                            <a href="shop-product-right.html">Shop now</a>
                                                        </div>
                                                    </div>
                                                    <div class="menu-banner-discount">
                                                        <h3>
                                                            <span>25%</span>
                                                            off
                                                        </h3>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="blog-category-grid.html">Blog <i class="fi-rs-angle-down"></i></a>
                                        <ul class="sub-menu">
                                            <li><a href="blog-category-grid.html">Blog Category Grid</a></li>
                                            <li><a href="blog-category-list.html">Blog Category List</a></li>
                                            <li><a href="blog-category-big.html">Blog Category Big</a></li>
                                            <li><a href="blog-category-fullwidth.html">Blog Category Wide</a></li>
                                            <li>
                                                <a href="#">Single Post <i class="fi-rs-angle-right"></i></a>
                                                <ul class="level-menu level-menu-modify">
                                                    <li><a href="blog-post-left.html">Left Sidebar</a></li>
                                                    <li><a href="blog-post-right.html">Right Sidebar</a></li>
                                                    <li><a href="blog-post-fullwidth.html">No Sidebar</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li> --}}
                                    <li>
                                        <a class="@if (Route::is('contact')) active @endif" href="{{ route('contact') }}">{{ __('Contact') }}</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="hotline d-none d-lg-flex">
                        @foreach ($settings as $setting)
                            <img src="{{ asset('frontend/assets/imgs/theme/icons/icon-headphone.svg')  }}" alt="hotline" />
                            <p>{{ $setting->support_phone ?? 'N/A' }}<span>24/7 Support Center</span></p>
                        @endforeach
                        
                    </div>
                    <div class="header-action-icon-2 d-block d-lg-none">
                        <div class="burger-icon burger-icon-white">
                            <span class="burger-icon-top"></span>
                            <span class="burger-icon-mid"></span>
                            <span class="burger-icon-bottom"></span>
                        </div>
                    </div>
                    <div class="header-action-right d-block d-lg-none">
                        <div class="header-action-2">
                            <div class="header-action-icon-2">
                                <a href="shop-wishlist.html">
                                    <img alt="Nest" src="{{ asset('frontend/assets/imgs/theme/icons/icon-heart.svg')  }}" />
                                    <span class="pro-count white">4</span>
                                </a>
                            </div>
                            <div class="header-action-icon-2">
                                <a class="mini-cart-icon" href="#">
                                    <img alt="Nest" src="{{ asset('frontend/assets/imgs/theme/icons/icon-cart.svg')  }}" />
                                    <span class="pro-count white">2</span>
                                </a>
                                <div class="cart-dropdown-wrap cart-dropdown-hm2">
                                    <ul>
                                        <li>
                                            <div class="shopping-cart-img">
                                                <a href="shop-product-right.html"><img alt="Nest" src="{{ asset('frontend/assets/imgs/shop/thumbnail-3.jpg')  }}" /></a>
                                            </div>
                                            <div class="shopping-cart-title">
                                                <h4><a href="shop-product-right.html">Plain Striola Shirts</a></h4>
                                                <h3><span>1 × </span>$800.00</h3>
                                            </div>
                                            <div class="shopping-cart-delete">
                                                <a href="#"><i class="fi-rs-cross-small"></i></a>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="shopping-cart-img">
                                                <a href="shop-product-right.html"><img alt="Nest" src="{{ asset('frontend/assets/imgs/shop/thumbnail-4.jpg')  }}" /></a>
                                            </div>
                                            <div class="shopping-cart-title">
                                                <h4><a href="shop-product-right.html">Macbook Pro 2022</a></h4>
                                                <h3><span>1 × </span>$3500.00</h3>
                                            </div>
                                            <div class="shopping-cart-delete">
                                                <a href="#"><i class="fi-rs-cross-small"></i></a>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="shopping-cart-footer">
                                        <div class="shopping-cart-total">
                                            <h4>Total <span>$383.00</span></h4>
                                        </div>
                                        <div class="shopping-cart-button">
                                            <a href="shop-cart.html">View cart</a>
                                            <a href="shop-checkout.html">Checkout</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="mobile-header-active mobile-header-wrapper-style">
        <div class="mobile-header-wrapper-inner">
            <div class="mobile-header-top">
                <div class="mobile-header-logo">
                    @foreach ($settings as $setting)
                        <a href="{{ route('home') }}"><img src="{{ asset('backend/img/settings/logo/'. $setting->logo) }}" alt="logo" /></a>
                    @endforeach
                </div>
                <div class="mobile-menu-close close-style-wrap close-style-position-inherit">
                    <button class="close-style search-close">
                        <i class="icon-top"></i>
                        <i class="icon-bottom"></i>
                    </button>
                </div>
            </div>
            <div class="mobile-header-content-area">
                <div class="mobile-search search-style-3 mobile-header-border">
                    <form action="#">
                        <input type="text" placeholder="Search for items…" />
                        <button type="submit"><i class="fi-rs-search"></i></button>
                    </form>
                </div>
                <div class="mobile-menu-wrap mobile-header-border">
                    <!-- mobile menu start -->
                    <nav>
                        <ul class="mobile-menu font-heading">
                            <li class="menu-item-has-children">
                                <a href="{{ route('home') }}">{{ __('Home') }}</a>
                            </li>
                            <li class="menu-item-has-children">
                                <a href="{{ route('shop') }}">{{ __('Shop') }}</a>
                            </li>
                            <li class="menu-item-has-children">
                                <a href="#">Mega menu</a>
                                <ul class="dropdown">
                                    <li class="menu-item-has-children">
                                        <a href="#">Women's Fashion</a>
                                        <ul class="dropdown">
                                            <li><a href="shop-product-right.html">Dresses</a></li>
                                            <li><a href="shop-product-right.html">Blouses & Shirts</a></li>
                                            <li><a href="shop-product-right.html">Hoodies & Sweatshirts</a></li>
                                            <li><a href="shop-product-right.html">Women's Sets</a></li>
                                        </ul>
                                    </li>
                                    <li class="menu-item-has-children">
                                        <a href="#">Men's Fashion</a>
                                        <ul class="dropdown">
                                            <li><a href="shop-product-right.html">Jackets</a></li>
                                            <li><a href="shop-product-right.html">Casual Faux Leather</a></li>
                                            <li><a href="shop-product-right.html">Genuine Leather</a></li>
                                        </ul>
                                    </li>
                                    <li class="menu-item-has-children">
                                        <a href="#">Technology</a>
                                        <ul class="dropdown">
                                            <li><a href="shop-product-right.html">Gaming Laptops</a></li>
                                            <li><a href="shop-product-right.html">Ultraslim Laptops</a></li>
                                            <li><a href="shop-product-right.html">Tablets</a></li>
                                            <li><a href="shop-product-right.html">Laptop Accessories</a></li>
                                            <li><a href="shop-product-right.html">Tablet Accessories</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu-item-has-children">
                                <a href="blog-category-fullwidth.html">Blog</a>
                                <ul class="dropdown">
                                    <li><a href="blog-category-grid.html">Blog Category Grid</a></li>
                                    <li><a href="blog-category-list.html">Blog Category List</a></li>
                                    <li><a href="blog-category-big.html">Blog Category Big</a></li>
                                    <li><a href="blog-category-fullwidth.html">Blog Category Wide</a></li>
                                    <li class="menu-item-has-children">
                                        <a href="#">Single Product Layout</a>
                                        <ul class="dropdown">
                                            <li><a href="blog-post-left.html">Left Sidebar</a></li>
                                            <li><a href="blog-post-right.html">Right Sidebar</a></li>
                                            <li><a href="blog-post-fullwidth.html">No Sidebar</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu-item-has-children">
                                <a href="{{ route('about') }}">{{ __('About Us') }}</a>
                            </li>
                            <li class="menu-item-has-children">
                                <a href="{{ route('contact') }}">{{ __('Contact') }}</a>
                            </li>
                            <li class="menu-item-has-children">
                                <a href="#">Language</a>
                                <ul class="dropdown">
                                    <li><a href="#">English</a></li>
                                    <li><a href="#">French</a></li>
                                    <li><a href="#">German</a></li>
                                    <li><a href="#">Spanish</a></li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                    <!-- mobile menu end -->
                </div>
                <div class="mobile-header-info-wrap">
                    <div class="single-mobile-header-info">
                        <a href="page-contact.html"><i class="fi-rs-marker"></i> Our location </a>
                    </div>
                    <div class="single-mobile-header-info">
                        <a href="{{ route('customerLogin') }}"><i class="fi-rs-user"></i>{{ __('Login / Register') }}</a>
                    </div>
                    <div class="single-mobile-header-info">
                        <a href="#"><i class="fi-rs-headphones"></i>(+01) - 2345 - 6789 </a>
                    </div>
                </div>
                <div class="mobile-social-icon mb-50">
                    <h6 class="mb-15">Follow Us</h6>
                    <a href="#"><img src="{{ asset('frontend/assets/imgs/theme/icons/icon-facebook-white.svg')  }}" alt="" /></a>
                    <a href="#"><img src="{{ asset('frontend/assets/imgs/theme/icons/icon-twitter-white.svg')  }}" alt="" /></a>
                    <a href="#"><img src="{{ asset('frontend/assets/imgs/theme/icons/icon-instagram-white.svg')  }}" alt="" /></a>
                    <a href="#"><img src="{{ asset('frontend/assets/imgs/theme/icons/icon-pinterest-white.svg')  }}" alt="" /></a>
                    <a href="#"><img src="{{ asset('frontend/assets/imgs/theme/icons/icon-youtube-white.svg')  }}" alt="" /></a>
                </div>
                <div class="site-copyright">Copyright 2022 © Nest. All rights reserved. Powered by AliThemes.</div>
            </div>
        </div>
    </div>