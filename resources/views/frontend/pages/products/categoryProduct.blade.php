@extends('frontend.layout.template')

@section('title', 'Shop')
@section('body-content')
    <main class="main">
        <div class="page-header mt-30 mb-50">
            <div class="container">
                <div class="archive-header">
                    <div class="row align-items-center">
                        <div class="col-xl-3">
                            @foreach ($cDetails as $category)
                                <h1 class="mb-15">{{ $category->name }}</h1>
                            @endforeach

                            <div class="breadcrumb">
                                <a href="{{ route('home') }}" rel="nofollow"><i
                                        class="fi-rs-home mr-5"></i>{{ __('Home') }}</a>
                                <span></span> {{ __('Category Products') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container mb-30">
            <div class="row flex-row-reverse">
                <div class="col-lg-4-5">
                    <div class="shop-product-fillter">
                        <div class="totall-product">
                            @foreach ($cDetails as $cat)
                                @php
                                    $numCount = DB::table('products')
                                        ->orderBy('id', 'asc')
                                        ->where('category_id', $cat->id)
                                        ->get();
                                @endphp
                                @if ($numCount->count() == 0)
                                    <p>{{ __('We found') }} <strong class="text-brand">{{ $numCount->count() }}</strong>
                                        {{ __('items in this category!') }}</p>
                                @else
                                    <p>{{ __('We found') }} <strong class="text-brand">{{ $cDetails->count() }}</strong>
                                        {{ __('items in this category!') }}</p>
                                @endif
                            @endforeach
                        </div>
                        <div class="sort-by-product-area">
                            <div class="sort-by-cover">
                                <div class="sort-by-product-wrap">
                                    <div class="sort-by">
                                        <span><i class="fi-rs-apps-sort"></i>Sort by:</span>
                                    </div>
                                    <div class="sort-by-dropdown-wrap">
                                        <span> Featured <i class="fi-rs-angle-small-down"></i></span>
                                    </div>
                                </div>
                                <div class="sort-by-dropdown">
                                    <ul>
                                        <li><a class="active" href="#">Featured</a></li>
                                        <li><a href="#">Price: Low to High</a></li>
                                        <li><a href="#">Price: High to Low</a></li>
                                        <li><a href="#">Release Date</a></li>
                                        <li><a href="#">Avg. Rating</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row product-grid">
                        @foreach ($cDetails as $category)
                            @php
                                $numCount = DB::table('products')
                                    ->orderBy('id', 'asc')
                                    ->where('category_id', $category->id)
                                    ->get();
                            @endphp
                            @if ($numCount->count() == 0)
                                <div class="alert alert-warning">{{ __('No Products Has Been Added To Ths Category!!') }}
                                </div>
                            @else
                                @foreach (App\Models\Product::orderBy('id', 'desc')->where('category_id', $category->id)->where('status', 1)->get() as $prDetails)
                                    <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                        <div class="product-cart-wrap mb-30">
                                            <div class="product-img-action-wrap">
                                                <div class="product-img product-img-zoom">
                                                    <a href="{{ route('singleProduct', $prDetails->slug) }}">
                                                        @php $img = 1; @endphp
                                                        @foreach ($prDetails->images as $image)
                                                            @if ($img > 0)
                                                                <img class="default-img"
                                                                    src="{{ asset('backend/img/products/' . $image->image) }}"
                                                                    alt="" />
                                                                @php $img--; @endphp
                                                            @endif
                                                            @if ($img == 2)
                                                                <img class="hover-img"
                                                                    src="{{ asset('backend/img/products/' . $image->image) }}"
                                                                    alt="" />
                                                                @php $img++; @endphp
                                                            @endif
                                                        @endforeach
                                                    </a>
                                                </div>
                                                <div class="product-action-1">
                                                    <form action="{{ route('wishlist.edit', $prDetails->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button type="submit" aria-label="Add To Wishlist"
                                                            class="action-btn wishlist-btn"
                                                            data-product-id="{{ $prDetails->id }}"
                                                            @auth wishlisted="{{ Maize\Markable\Models\Favorite::has($prDetails, Auth::user()) ? 'true' : '' }}"
                                                        style="{{ Maize\Markable\Models\Favorite::has($prDetails, Auth::user()) ? 'color: red;' : '' }}" @endauth>
                                                            <i class="fi-rs-heart"></i>
                                                        </button>
                                                        <a aria-label="Compare" class="action-btn"
                                                            href="shop-compare.html"><i class="fi-rs-shuffle"></i></a>
                                                        <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal"
                                                            data-bs-target="#quickViewModal-{{ $prDetails->id }}"><i
                                                                class="fi-rs-eye"></i></a>
                                                    </form>
                                                </div>
                                                @include('frontend.includes.quickview')
                                                <div class="product-badges product-badges-position product-badges-mrg">
                                                    @if ($prDetails->is_featured == 1 && $prDetails->offer_price)
                                                        <span class="best">{{ __('Hot & Sale') }}</span>
                                                    @elseif ($prDetails->is_featured == 1)
                                                        <span class="hot">{{ __('Hot') }}</span>
                                                    @elseif ($prDetails->is_featured == 0)
                                                        @if (!is_null($prDetails->offer_price))
                                                            <span class="sale">{{ __('Sale') }}</span>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="product-content-wrap">
                                                <div class="product-category">
                                                    <a href="">{{ $prDetails->category->name ?? 'N/A' }}</a>
                                                </div>
                                                <h2><a
                                                        href="{{ route('singleProduct', $prDetails->slug) }}">{{ $prDetails->name }}</a>
                                                </h2>
                                                <div class="product-rate-cover">
                                                    <div class="product-rate d-inline-block">
                                                        <div class="product-rating" style="width: 90%"></div>
                                                    </div>
                                                    <span class="font-small ml-5 text-muted"> (4.0)</span>
                                                </div>
                                                <div>
                                                    @if (!is_null($prDetails->offer_price))
                                                        <span class="font-small text-muted">{{ __('Save') }} <a
                                                                href="">{{ $prDetails->offer_price }} %</a></span>
                                                    @endif
                                                </div>
                                                <div class="product-card-bottom">
                                                    <div class="product-price">
                                                        @if (!is_null($prDetails->offer_price))
                                                            @php
                                                                $totalSave = $prDetails->regular_price * ($prDetails->offer_price / 100);
                                                            @endphp
                                                            <span>{{ $prDetails->regular_price - $totalSave }}
                                                                {{ __('BDT') }}</span>
                                                            <span class="old-price">{{ $prDetails->regular_price }}
                                                                {{ __('BDT') }}</span>
                                                        @else
                                                            <span>{{ $prDetails->regular_price }}
                                                                {{ __('BDT') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="detail-extralink">
                                                        <form action="{{ route('cart.store') }}" method="POST">
                                                            @csrf
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="detail-qty bordeproductr radius">
                                                                        <a href="#" class="qty-down"><i
                                                                                class="fi-rs-angle-small-down"></i></a>
                                                                        <input type="text" name="quantity"
                                                                            class="qty-val" value="1" min="1">
                                                                        <a href="#" class="qty-up"><i
                                                                                class="fi-rs-angle-small-up"></i></a>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="add-cart">
                                                                        <input type="hidden" name="product_id"
                                                                            value="{{ $prDetails->id }}">
                                                                        @if (!is_null($prDetails->offer_price))
                                                                            @php
                                                                                $totalSave = $prDetails->regular_price * ($prDetails->offer_price / 100);
                                                                            @endphp
                                                                            <input type="hidden" name="unit_price"
                                                                                value="{{ $prDetails->regular_price - $totalSave }}">
                                                                        @else
                                                                            <input type="hidden" name="unit_price"
                                                                                value="{{ $prDetails->regular_price }}">
                                                                        @endif
                                                                        <button class="add" type="submit"><i
                                                                                class="fi-rs-shopping-cart mr-5"></i>{{ __('Add') }}</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        @endforeach
                    </div>
                    <!--product grid-->
                    <div class="pagination-area mt-20 mb-20">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-start">
                                {{ $cDetails->links() }}
                            </ul>
                        </nav>
                    </div>
                    <section class="section-padding pb-5">
                        <div class="section-title">
                            <h3 class="">Deals Of The Day</h3>
                            <a class="show-all" href="shop-grid-right.html">
                                All Deals
                                <i class="fi-rs-angle-right"></i>
                            </a>
                        </div>
                        <div class="row">
                            <div class="col-xl-3 col-lg-4 col-md-6">
                                <div class="product-cart-wrap style-2">
                                    <div class="product-img-action-wrap">
                                        <div class="product-img">
                                            <a href="shop-product-right.html">
                                                <img src="{{ asset('frontend/assets/imgs/banner/banner-5.png') }}"
                                                    alt="" />
                                            </a>
                                        </div>
                                    </div>
                                    <div class="product-content-wrap">
                                        <div class="deals-countdown-wrap">
                                            <div class="deals-countdown" data-countdown="2025/03/25 00:00:00"></div>
                                        </div>
                                        <div class="deals-content">
                                            <h2><a href="shop-product-right.html">Seeds of Change Organic Quinoa, Brown</a>
                                            </h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a
                                                        href="vendor-details-1.html">NestFood</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$32.85</span>
                                                    <span class="old-price">$33.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class="add" href="shop-cart.html"><i
                                                            class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-6">
                                <div class="product-cart-wrap style-2">
                                    <div class="product-img-action-wrap">
                                        <div class="product-img">
                                            <a href="shop-product-right.html">
                                                <img src="{{ asset('frontend/assets/imgs/banner/banner-6.png') }}"
                                                    alt="" />
                                            </a>
                                        </div>
                                    </div>
                                    <div class="product-content-wrap">
                                        <div class="deals-countdown-wrap">
                                            <div class="deals-countdown" data-countdown="2026/04/25 00:00:00"></div>
                                        </div>
                                        <div class="deals-content">
                                            <h2><a href="shop-product-right.html">Perdue Simply Smart Organics Gluten</a>
                                            </h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a href="vendor-details-1.html">Old
                                                        El Paso</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$24.85</span>
                                                    <span class="old-price">$26.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class="add" href="shop-cart.html"><i
                                                            class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-6 d-none d-lg-block">
                                <div class="product-cart-wrap style-2">
                                    <div class="product-img-action-wrap">
                                        <div class="product-img">
                                            <a href="shop-product-right.html">
                                                <img src="{{ asset('frontend/assets/imgs/banner/banner-7.png') }}"
                                                    alt="" />
                                            </a>
                                        </div>
                                    </div>
                                    <div class="product-content-wrap">
                                        <div class="deals-countdown-wrap">
                                            <div class="deals-countdown" data-countdown="2027/03/25 00:00:00"></div>
                                        </div>
                                        <div class="deals-content">
                                            <h2><a href="shop-product-right.html">Signature Wood-Fired Mushroom</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 80%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (3.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a
                                                        href="vendor-details-1.html">Progresso</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$12.85</span>
                                                    <span class="old-price">$13.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class="add" href="shop-cart.html"><i
                                                            class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-6 d-none d-xl-block">
                                <div class="product-cart-wrap style-2">
                                    <div class="product-img-action-wrap">
                                        <div class="product-img">
                                            <a href="shop-product-right.html">
                                                <img src="{{ asset('frontend/assets/imgs/banner/banner-8.png') }}"
                                                    alt="" />
                                            </a>
                                        </div>
                                    </div>
                                    <div class="product-content-wrap">
                                        <div class="deals-countdown-wrap">
                                            <div class="deals-countdown" data-countdown="2025/02/25 00:00:00"></div>
                                        </div>
                                        <div class="deals-content">
                                            <h2><a href="shop-product-right.html">Simply Lemonade with Raspberry Juice</a>
                                            </h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 80%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (3.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">By <a
                                                        href="vendor-details-1.html">Yoplait</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>$15.85</span>
                                                    <span class="old-price">$16.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class="add" href="shop-cart.html"><i
                                                            class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!--End Deals-->
                </div>
                {{-- SideBar --}}
                <div class="col-lg-1-5 primary-sidebar sticky-sidebar">
                    @include('frontend.includes.sidebar')
                </div>
            </div>
        </div>
    </main>

@endsection

@push('extraScripts')
    @include('frontend.includes.extraScript.wishlistAjax')
@endpush
