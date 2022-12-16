@extends('frontend.layout.template')

@section('title', 'Product')
@section('body-content')

    @include('frontend.includes.quickview')

    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{ route('home') }}" rel="nofollow"><i class="fi-rs-home mr-5"></i>{{ __('Home') }}</a>
                    <span></span>
                    <a href="{{ route('shop') }}" rel="nofollow"></i>{{ __('Shop') }}</a>
                    <span></span>
                    <a href="shop-grid-right.html">
                        @foreach ( App\Models\Category::orderBy('id', 'asc')->where('id',$prDetails->category->is_parent)->get() as $pCat)
                        {{ $pCat->name }}
                        @endforeach
                    </a>
                    <span></span> {{ $prDetails->category->name}}
                </div>
            </div>
        </div>
        <div class="container mb-30">
            <div class="row">
                <div class="col-xl-10 col-lg-12 m-auto">
                    <div class="product-detail accordion-detail">
                        <div class="row mb-50 mt-30">
                            <div class="col-md-6 col-sm-12 col-xs-12 mb-md-0 mb-sm-5">
                                <div class="detail-gallery">
                                    <span class="zoom-icon"><i class="fi-rs-search"></i></span>
                                    <!-- MAIN SLIDES -->
                                    <div class="product-image-slider">
                                        @foreach ($prDetails->images as $image)
                                        <figure class="border-radius-10">
                                            <img src="{{ asset('backend/img/products/' . $image->image) }}" alt="product image" />
                                        </figure>
                                        @endforeach
                                    </div>
                                    <!-- THUMBNAILS -->
                                    <div class="slider-nav-thumbnails">
                                        @foreach ($prDetails->images as $image)
                                            <div><img src="{{ asset('backend/img/products/' . $image->image) }}" alt="product image" /></div>
                                        @endforeach
                                    </div>
                                </div>
                                <!-- End Gallery -->
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="detail-info pr-30 pl-30">
                                    @if ($prDetails->is_featured == 1 && $prDetails->offer_price)
                                        <span class="stock-status in-stock">{{ __('Hot & Sale') }}</span>
                                    @elseif ($prDetails->is_featured == 1)
                                        <span class="stock-status in-stock">{{ __('Hot') }}</span>
                                    @elseif ($prDetails->is_featured == 0)
                                        @if (!is_null($prDetails->offer_price))
                                            <span class="stock-status out-stock">{{ __('Sale') }}</span>
                                        @endif
                                    @endif
                                    <h2 class="title-detail">{{ $prDetails->name }}</h2>
                                    
                                    <div class="product-detail-rating">
                                        <div class="product-rate-cover text-end">
                                            @foreach ($reviews as $review)
                                                
                                            @endforeach
                                            <div class="d-inline-block">
                                                <form action="">
                                                    <ul class="shop-rate-area">
                                                        <input type="radio" id="5-star" name="rating" value="5" @if ($review->rating == 5) checked @endif />
                                                        <label for="5-star" title="Amazing">5 stars</label>
                                                        <input type="radio" id="4-star" name="rating" value="4" @if ($review->rating == 4) checked @endif/>
                                                        <label for="4-star" title="Good">4 stars</label>
                                                        <input type="radio" id="3-star" name="rating" value="3" @if ($review->rating == 3) checked @endif/>
                                                        <label for="3-star" title="Average">3 stars</label>
                                                        <input type="radio" id="2-star" name="rating" value="2" @if ($review->rating == 2) checked @endif/>
                                                        <label for="2-star" title="Not Good">2 stars</label>
                                                        <input type="radio" id="1-star" name="rating" value="1" @if ($review->rating == 1) checked @endif/>
                                                        <label for="1-star" title="Bad">1 star</label>
                                                    </ul>
                                                </form>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> ({{ $reviews->count() }} reviews)</span>
                                        </div>
                                    </div>

                                    <div class="clearfix product-price-cover">
                                        <div class="product-price primary-color float-left">
                                            @if (!is_null($prDetails->offer_price))
                                                @php
                                                    $totalSave = ($prDetails->regular_price *($prDetails->offer_price /100) );
                                                @endphp
                                                <span class="current-price text-brand">{{ $prDetails->regular_price - $totalSave }} {{ __('BDT') }}</span>
                                                <span>
                                                    @if (!is_null($prDetails->offer_price))
                                                        <span class="save-price font-md color3 ml-15"">{{ $prDetails->offer_price }} {{ __('% Off') }}</span>
                                                    @endif
                                                        <span class="old-price font-md ml-15">{{ $prDetails->regular_price }} {{ __('BDT') }}</span>
                                                </span>
                                            @else
                                                <span class="current-price text-brand">{{ $prDetails->regular_price }} {{ __('BDT') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="short-desc mb-30">
                                        <p class="font-lg">{!! $prDetails->short_desc ?? 'No Description Added!' !!}</p>
                                    </div>
                                    <div class="attr-detail attr-size mb-30">
                                        <strong class="mr-10">Size / Weight: </strong>
                                        <ul class="list-filter size-filter font-small">
                                            <li><a href="#">50g</a></li>
                                            <li class="active"><a href="#">60g</a></li>
                                            <li><a href="#">80g</a></li>
                                            <li><a href="#">100g</a></li>
                                            <li><a href="#">150g</a></li>
                                        </ul>
                                    </div>
                                    <div class="detail-extralink mb-50">
                                        <form action="{{ route('cart.store') }}" method="POST">
                                            @csrf
                                            <div class="detail-qty bordeproductr radius">
                                                <a href="#" class="qty-down"><i class="fi-rs-angle-small-down"></i></a>
                                                <input type="text" name="quantity" class="qty-val" value="1" min="1">
                                                <a href="#" class="qty-up"><i class="fi-rs-angle-small-up"></i></a>
                                            </div>
                                            <div class="product-extra-link2">
                                                <input type="hidden" name="product_id" value="{{ $prDetails->id }}">
                                                @if (!is_null($prDetails->offer_price))
                                                    @php
                                                        $totalSave = ($prDetails->regular_price *($prDetails->offer_price /100) );
                                                    @endphp
                                                    <input type="hidden" name="unit_price" value="{{ $prDetails->regular_price - $totalSave }}">
                                                @else
                                                    <input type="hidden" name="unit_price" value="{{ $prDetails->regular_price }}">
                                                @endif
                                                <button type="submit" class="button button-add-to-cart"><i class="fi-rs-shopping-cart"></i>{{ __('Add To Cart') }}</button>
                                                <a aria-label="Add To Wishlist" class="action-btn hover-up" href="shop-wishlist.html"><i class="fi-rs-heart"></i></a>
                                                <a aria-label="Compare" class="action-btn hover-up" href="shop-compare.html"><i class="fi-rs-shuffle"></i></a>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="font-xs">
                                        <ul class="mr-50 float-start">
                                            <li class="mb-5">{{ __('Type:') }} <span class="text-brand"> @if ($prDetails->product_type == 0)
                                                {{ __('Physical') }}
                                            @elseif (($product->product_type == 1))
                                                {{ __('Digital') }}
                                            @elseif (($prDetails->product_type == 2))
                                                {{ __('Organic') }}
                                            @endif</span></li>
                                            <li class="mb-5">{{ __('MFG:') }} <span class="text-brand"> {{ $prDetails->mfg_date ?? 'N/A' }}</span></li>
                                            <li>{{ __('Expire:') }} <span class="text-brand"> {{ $prDetails->exp_date ?? 'N/A' }}</span></li>
                                        </ul>
                                        <ul class="float-start">
                                            <li class="mb-5">{{ __('SKU:') }} <a href="#">{{ $prDetails->sku_code ?? 'N/A' }}</a></li>
                                            <li class="mb-5">{{ __('Tags:') }} <a href="#" rel="tag">{{ $prDetails->product_tags ?? 'N/A' }}</a></li>
                                            <li>{{ __('Stock:') }} <span class="in-stock text-brand ml-5">{{ $prDetails->quantity }} {{ __('In Stock') }}</span></li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- Detail Info -->
                            </div>
                        </div>
                        <div class="product-info">
                            <div class="tab-style3">
                                <ul class="nav nav-tabs text-uppercase">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="Description-tab" data-bs-toggle="tab" href="#Description">{{ __('Description') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="Additional-info-tab" data-bs-toggle="tab" href="#Additional-info">{{ __('Additional info') }}</a>
                                    </li>
                                    {{-- <li class="nav-item">
                                        <a class="nav-link" id="Vendor-info-tab" data-bs-toggle="tab" href="#Vendor-info">Vendor</a>
                                    </li> --}}
                                    <li class="nav-item">
                                        <a class="nav-link" id="Reviews-tab" data-bs-toggle="tab" href="#Reviews">Reviews ({{ $reviews->count()}})</a>
                                    </li>
                                </ul>
                                <div class="tab-content shop_info_tab entry-main-content">
                                    <div class="tab-pane fade show active" id="Description">
                                        <div class="">
                                            <p>{!! $prDetails->long_desc ?? 'No Description Added!' !!}</p>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="Additional-info">
                                        <p>{!! $prDetails->additional_info ?? 'No Info Added!' !!}</p>
                                    </div>
                                    {{-- <div class="tab-pane fade" id="Vendor-info">
                                        <div class="vendor-logo d-flex mb-30">
                                            <img src="{{ asset('frontend/assets/imgs/vendor/vendor-18.svg') }}" alt="" />
                                            <div class="vendor-name ml-15">
                                                <h6>
                                                    <a href="vendor-details-2.html">Noodles Co.</a>
                                                </h6>
                                                <div class="product-rate-cover text-end">
                                                    <div class="product-rate d-inline-block">
                                                        <div class="product-rating" style="width: 90%"></div>
                                                    </div>
                                                    <span class="font-small ml-5 text-muted"> (32 reviews)</span>
                                                </div>
                                            </div>
                                        </div>
                                        <ul class="contact-infor mb-50">
                                            <li><img src="{{ asset('frontend/assets/imgs/theme/icons/icon-location.svg') }}" alt="" /><strong>Address: </strong> <span>5171 W Campbell Ave undefined Kent, Utah 53127 United States</span></li>
                                            <li><img src="{{ asset('frontend/assets/imgs/theme/icons/icon-contact.svg') }}" alt="" /><strong>Contact Seller:</strong><span>(+91) - 540-025-553</span></li>
                                        </ul>
                                        <div class="d-flex mb-55">
                                            <div class="mr-30">
                                                <p class="text-brand font-xs">Rating</p>
                                                <h4 class="mb-0">92%</h4>
                                            </div>
                                            <div class="mr-30">
                                                <p class="text-brand font-xs">Ship on time</p>
                                                <h4 class="mb-0">100%</h4>
                                            </div>
                                            <div>
                                                <p class="text-brand font-xs">Chat response</p>
                                                <h4 class="mb-0">89%</h4>
                                            </div>
                                        </div>
                                        <p>Noodles & Company is an American fast-casual restaurant that offers international and American noodle dishes and pasta in addition to soups and salads. Noodles & Company was founded in 1995 by Aaron Kennedy and is headquartered in Broomfield, Colorado. The company went public in 2013 and recorded a $457 million revenue in 2017.In late 2018, there were 460 Noodles & Company locations across 29 states and Washington, D.C.</p>
                                    </div> --}}
                                    <div class="tab-pane fade" id="Reviews">
                                        <!--Comments-->
                                        <div class="comments-area">
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    <h4 class="mb-30">Customer questions & answers</h4>
                                                    <div class="comment-list">
                                                        @foreach ($reviews as $review)
                                                            <div class="single-comment justify-content-between d-flex mb-30">
                                                                <div class="user justify-content-between d-flex">
                                                                    <div class="thumb text-center">
                                                                        <img src="{{ asset('backend/img/Default.png') }}" alt="" /><br>
                                                                        <a href="#" class="font-heading text-brand">{{ $review->user->name }}</a>
                                                                    </div>
                                                                    <div class="desc">
                                                                        <div class="d-flex justify-content-between mb-10">
                                                                            <div class="d-flex align-items-center">
                                                                                <span class="font-xs text-muted">{{ $review->created_at->toDayDateTimeString() }} </span>
                                                                            </div>

                                                                            <div class="d-inline-block">
                                                                            <form action="">
                                                                                <ul class="shop-rate-area">
                                                                                    <input type="radio" id="5-star" name="rating" value="5" @if ($review->rating == 5) checked @endif />
                                                                                    <label for="5-star" title="Amazing">5 stars</label>
                                                                                    <input type="radio" id="4-star" name="rating" value="4" @if ($review->rating == 4) checked @endif/>
                                                                                    <label for="4-star" title="Good">4 stars</label>
                                                                                    <input type="radio" id="3-star" name="rating" value="3" @if ($review->rating == 3) checked @endif/>
                                                                                    <label for="3-star" title="Average">3 stars</label>
                                                                                    <input type="radio" id="2-star" name="rating" value="2" @if ($review->rating == 2) checked @endif/>
                                                                                    <label for="2-star" title="Not Good">2 stars</label>
                                                                                    <input type="radio" id="1-star" name="rating" value="1" @if ($review->rating == 1) checked @endif/>
                                                                                    <label for="1-star" title="Bad">1 star</label>
                                                                                </ul>
                                                                            </form>
                                                                            </div>
                                                                        </div>
                                                                        <p class="mb-10">{{ $review->comment }} <a href="#" class="reply">Reply</a></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <h4 class="mb-30">Customer reviews</h4>
                                                    <div class="d-flex mb-30">
                                                        <div class=" d-inline-block mr-15">
                                                            <ul class="customer-rate-area">
                                                                <input type="radio" id="5-star" name="rating" value="5" @if ($review->rating == 5) checked @endif />
                                                                <label for="5-star" title="Amazing">5 stars</label>
                                                                <input type="radio" id="4-star" name="rating" value="4" @if ($review->rating == 4) checked @endif/>
                                                                <label for="4-star" title="Good">4 stars</label>
                                                                <input type="radio" id="3-star" name="rating" value="3" @if ($review->rating == 3) checked @endif/>
                                                                <label for="3-star" title="Average">3 stars</label>
                                                                <input type="radio" id="2-star" name="rating" value="2" @if ($review->rating == 2) checked @endif/>
                                                                <label for="2-star" title="Not Good">2 stars</label>
                                                                <input type="radio" id="1-star" name="rating" value="1" @if ($review->rating == 1) checked @endif/>
                                                                <label for="1-star" title="Bad">1 star</label>
                                                            </ul>
                                                        </div>
                                                        @php
                                                            $totalRating = 0;
                                                        @endphp
                                                        @foreach ($reviews as $review)
                                                            @php
                                                                $totalRating += $review->rating
                                                            @endphp
                                                        @endforeach
                                                        <h6>@if (!is_null($totalRating))
                                                            {{ $totalRating / $reviews->count() ?? '0' }} out of 5
                                                        @else
                                                            0 out of 5
                                                        @endif</h6>
                                                    </div>
                                                    @php
                                                        $totalFive = DB::table('product_reviews') ->where('rating', 5) ->count();
                                                        $totalFour = DB::table('product_reviews') ->where('rating', 4) ->count();
                                                        $totalThree = DB::table('product_reviews') ->where('rating', 3) ->count();
                                                        $totalTwo = DB::table('product_reviews') ->where('rating', 2) ->count();
                                                        $totalOne = DB::table('product_reviews') ->where('rating', 1) ->count();

                                                        $five   = ($totalFive / $reviews->count() * 100);
                                                        $four   = ($totalFour / $reviews->count() * 100);
                                                        $three  = ($totalThree / $reviews->count() * 100);
                                                        $two    = ($totalTwo / $reviews->count() * 100);
                                                        $one    = ($totalOne / $reviews->count() * 100);
                                                    @endphp
                                                    <div class="progress">
                                                        <span>5 star</span>
                                                        <div class="progress-bar" role="progressbar" aria-valuenow="{{ $five}}" aria-valuemin="0" aria-valuemax="100">{{ $five }}%</div>
                                                    </div>
                                                    <div class="progress">
                                                        <span>4 star</span>
                                                        <div class="progress-bar" role="progressbar" aria-valuenow="{{ $four}}" aria-valuemin="0" aria-valuemax="100">{{ $four }}%</div>
                                                    </div>
                                                    <div class="progress">
                                                        <span>3 star</span>
                                                        <div class="progress-bar" role="progressbar" aria-valuenow="{{ $three}}" aria-valuemin="0" aria-valuemax="100">{{ $three }}%</div>
                                                    </div>
                                                    <div class="progress">
                                                        <span>2 star</span>
                                                        <div class="progress-bar" role="progressbar" aria-valuenow="{{ $two }}" aria-valuemin="0" aria-valuemax="100">{{ $two }}%</div>
                                                    </div>
                                                    <div class="progress mb-30">
                                                        <span>1 star</span>
                                                        <div class="progress-bar" role="progressbar" aria-valuenow="{{ $one}}" aria-valuemin="0" aria-valuemax="100">{{ $one }}%</div>
                                                    </div>
                                                    <a href="#" class="font-xs text-muted">How are ratings calculated?</a>
                                                </div>
                                            </div>
                                        </div>
                                        <!--comment form-->
                                        <div class="comment-form">
                                            <h4 class="mb-15">Add a review</h4>

                                            <div class="product-rate d-inline-block mb-30"></div>
                                            <div class="row">
                                                <div class="col-lg-8 col-md-12">
                                                    <form class="form-contact comment_form" action="#" id="commentForm">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <textarea class="form-control w-100" name="comment" id="comment" cols="30" rows="9" placeholder="Write Comment"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <button type="submit" class="button button-contactForm">Submit Review</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-60">
                            <div class="col-12">
                                <h2 class="section-title style-1 mb-30">Related products</h2>
                            </div>
                            <div class="col-12">
                                <div class="row related-products">
                                    <div class="col-lg-3 col-md-4 col-12 col-sm-6">
                                        <div class="product-cart-wrap hover-up">
                                            <div class="product-img-action-wrap">
                                                <div class="product-img product-img-zoom">
                                                    <a href="shop-product-right.html" tabindex="0">
                                                        <img class="default-img" src="{{ asset('frontend/assets/imgs/shop/product-2-1.jpg') }}" alt="" />
                                                        <img class="hover-img" src="{{ asset('frontend/assets/imgs/shop/product-2-2.jpg') }}" alt="" />
                                                    </a>
                                                </div>
                                                <div class="product-action-1">
                                                    <a aria-label="Quick view" class="action-btn small hover-up" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-search"></i></a>
                                                    <a aria-label="Add To Wishlist" class="action-btn small hover-up" href="shop-wishlist.html" tabindex="0"><i class="fi-rs-heart"></i></a>
                                                    <a aria-label="Compare" class="action-btn small hover-up" href="shop-compare.html" tabindex="0"><i class="fi-rs-shuffle"></i></a>
                                                </div>
                                                <div class="product-badges product-badges-position product-badges-mrg">
                                                    <span class="hot">Hot</span>
                                                </div>
                                            </div>
                                            <div class="product-content-wrap">
                                                <h2><a href="shop-product-right.html" tabindex="0">Ulstra Bass Headphone</a></h2>
                                                <div class="rating-result" title="90%">
                                                    <span> </span>
                                                </div>
                                                <div class="product-price">
                                                    <span>$238.85 </span>
                                                    <span class="old-price">$245.8</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-12 col-sm-6">
                                        <div class="product-cart-wrap hover-up">
                                            <div class="product-img-action-wrap">
                                                <div class="product-img product-img-zoom">
                                                    <a href="shop-product-right.html" tabindex="0">
                                                        <img class="default-img" src="{{ asset('frontend/assets/imgs/shop/product-3-1.jpg') }}" alt="" />
                                                        <img class="hover-img" src="{{ asset('frontend/assets/imgs/shop/product-4-2.jpg') }}" alt="" />
                                                    </a>
                                                </div>
                                                <div class="product-action-1">
                                                    <a aria-label="Quick view" class="action-btn small hover-up" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-search"></i></a>
                                                    <a aria-label="Add To Wishlist" class="action-btn small hover-up" href="shop-wishlist.html" tabindex="0"><i class="fi-rs-heart"></i></a>
                                                    <a aria-label="Compare" class="action-btn small hover-up" href="shop-compare.html" tabindex="0"><i class="fi-rs-shuffle"></i></a>
                                                </div>
                                                <div class="product-badges product-badges-position product-badges-mrg">
                                                    <span class="sale">-12%</span>
                                                </div>
                                            </div>
                                            <div class="product-content-wrap">
                                                <h2><a href="shop-product-right.html" tabindex="0">Smart Bluetooth Speaker</a></h2>
                                                <div class="rating-result" title="90%">
                                                    <span> </span>
                                                </div>
                                                <div class="product-price">
                                                    <span>$138.85 </span>
                                                    <span class="old-price">$145.8</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-12 col-sm-6">
                                        <div class="product-cart-wrap hover-up">
                                            <div class="product-img-action-wrap">
                                                <div class="product-img product-img-zoom">
                                                    <a href="shop-product-right.html" tabindex="0">
                                                        <img class="default-img" src="{{ asset('frontend/assets/imgs/shop/product-4-1.jpg') }}" alt="" />
                                                        <img class="hover-img" src="{{ asset('frontend/assets/imgs/shop/product-4-2.jpg') }}" alt="" />
                                                    </a>
                                                </div>
                                                <div class="product-action-1">
                                                    <a aria-label="Quick view" class="action-btn small hover-up" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-search"></i></a>
                                                    <a aria-label="Add To Wishlist" class="action-btn small hover-up" href="shop-wishlist.html" tabindex="0"><i class="fi-rs-heart"></i></a>
                                                    <a aria-label="Compare" class="action-btn small hover-up" href="shop-compare.html" tabindex="0"><i class="fi-rs-shuffle"></i></a>
                                                </div>
                                                <div class="product-badges product-badges-position product-badges-mrg">
                                                    <span class="new">New</span>
                                                </div>
                                            </div>
                                            <div class="product-content-wrap">
                                                <h2><a href="shop-product-right.html" tabindex="0">HomeSpeak 12UEA Goole</a></h2>
                                                <div class="rating-result" title="90%">
                                                    <span> </span>
                                                </div>
                                                <div class="product-price">
                                                    <span>$738.85 </span>
                                                    <span class="old-price">$1245.8</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-12 col-sm-6 d-lg-block d-none">
                                        <div class="product-cart-wrap hover-up mb-0">
                                            <div class="product-img-action-wrap">
                                                <div class="product-img product-img-zoom">
                                                    <a href="shop-product-right.html" tabindex="0">
                                                        <img class="default-img" src="{{ asset('frontend/assets/imgs/shop/product-5-1.jpg') }}" alt="" />
                                                        <img class="hover-img" src="{{ asset('frontend/assets/imgs/shop/product-3-2.jpg') }}" alt="" />
                                                    </a>
                                                </div>
                                                <div class="product-action-1">
                                                    <a aria-label="Quick view" class="action-btn small hover-up" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-search"></i></a>
                                                    <a aria-label="Add To Wishlist" class="action-btn small hover-up" href="shop-wishlist.html" tabindex="0"><i class="fi-rs-heart"></i></a>
                                                    <a aria-label="Compare" class="action-btn small hover-up" href="shop-compare.html" tabindex="0"><i class="fi-rs-shuffle"></i></a>
                                                </div>
                                                <div class="product-badges product-badges-position product-badges-mrg">
                                                    <span class="hot">Hot</span>
                                                </div>
                                            </div>
                                            <div class="product-content-wrap">
                                                <h2><a href="shop-product-right.html" tabindex="0">Dadua Camera 4K 2022EF</a></h2>
                                                <div class="rating-result" title="90%">
                                                    <span> </span>
                                                </div>
                                                <div class="product-price">
                                                    <span>$89.8 </span>
                                                    <span class="old-price">$98.8</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection
