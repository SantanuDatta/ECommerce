@extends('frontend.layout.template')

@section('title', 'Wishlist')
@section('body-content')
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="index.html" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                    <span></span> Shop <span></span> Fillter
                </div>
            </div>
        </div>
        @php
            $wishCount = DB::table('markable_favorites')->where('user_id', Auth::user()?->id)->get();
        @endphp
        <div class="container mb-30 mt-50">
            <div class="row">
                <div class="col-xl-10 col-lg-12 m-auto">
                    <div class="mb-50">
                        <h1 class="heading-2 mb-10">Your Wishlist</h1>
                        <h6 class="text-body">There are <span class="text-brand">{{ $wishCount->count() }}</span> products in this list</h6>
                    </div>
                    
                    @if ($wishCount->count() == 0)
                        <div class="alert alert-warning">{{ __('No Product Has Been Wishlisted Yet!') }}</div>
                    @else
                    @php
                        $totalAmount = 0;
                    @endphp
                        <div class="table-responsive shopping-summery">
                            <table class="table table-wishlist">
                                <thead>
                                    <tr class="main-heading">
                                        <th class="start pl-30" scope="col" colspan="2">{{ __('Product') }}</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Action</th>
                                        <th scope="col" class="end">Remove</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($prDetails as $product)
                                        <tr class="pt-30">
                                            <td class="image product-thumbnail pt-40 pl-10">
                                                @php $img = 1; @endphp
                                                    @if ($product->images->count() > 0)
                                                        <img src="{{ asset('backend/img/products/' . $product->images->first()->image) }}" alt="#" />
                                                    @endif
                                            </td>
                                            <td class="product-des product-name">
                                                <h6 class="mb-5"><a class="product-name mb-10 text-heading" href="{{ route('singleProduct', $product->slug) }}">{{ $product->name }}</a></h6>
                                                <div class="product-rate-cover">
                                                    <div class="product-rate d-inline-block">
                                                        <div class="product-rating" style="width:90%">
                                                        </div>
                                                    </div>
                                                    <span class="font-small ml-5 text-muted"> (4.0)</span>
                                                </div>
                                            </td>
                                            <td class="price" data-title="Price">
                                                <h4 class="text-body">
                                                    @if (!is_null($product->offer_price))
                                                        @php
                                                            $totalSave = ($product->regular_price *($product->offer_price /100) );
                                                            $savedAmount = $product->regular_price - $totalSave;
                                                        @endphp
                                                        {{ $savedAmount }} {{ __('BDT') }}
                                                        @php
                                                            $totalAmount += $savedAmount * $product->quantity;
                                                        @endphp
                                                    @else
                                                        {{ $product->regular_price }} {{ __('BDT') }}
                                                        @php
                                                            $totalAmount += $product->regular_price * $product->quantity;
                                                        @endphp
                                                    @endif 
                                                </h4>
                                            </td>
                                            <td class="text-right" data-title="Cart">
                                                <button class="btn btn-sm">Add to cart</button>
                                            </td>
                                            <td class="action text-center" data-title="Remove">
                                                <form action="{{ route('wishlist.destroy', $product->id) }}" method="POST" class="cart-destroy">
                                                    @csrf
                                                        <button type="submit" class="cart-btn-destroy"><i class="fi-rs-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
@endsection