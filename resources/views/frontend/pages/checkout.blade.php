@extends('frontend.layout.template')

@section('title', 'Checkout')
@section('body-content')

    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{ route('home') }}" rel="nofollow"><i class="fi-rs-home mr-5"></i>{{ __('Home') }}</a>
                    <span></span> <a href="{{ route('shop') }}" rel="nofollow"></i>{{ __('Shop') }}</a>
                    <span></span> {{ __('Checkout') }}
                </div>
            </div>
        </div>
        <div class="container mb-80 mt-50">
            <div class="row">
                <div class="col-lg-8 mb-40">
                    <h1 class="heading-2 mb-10">{{ __('Checkout') }}</h1>
                    <div class="d-flex justify-content-between">
                        <h6 class="text-body">{{ __('There are') }} <span class="text-brand">{{ App\Models\Cart::totalItems() }}</span> {{ __('products in your cart') }}</h6>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-7">
                    <div class="row mb-50">
                        <div class="col-lg-6 mb-sm-15 mb-lg-0 mb-md-3">
                            <div class="toggle_info">
                                <span><i class="fi-rs-user mr-10"></i><span class="text-muted font-lg">Already have an account?</span> <a href="#loginform" data-bs-toggle="collapse" class="collapsed font-lg" aria-expanded="false">Click here to login</a></span>
                            </div>
                            <div class="panel-collapse collapse login_form" id="loginform">
                                <div class="panel-body">
                                    <p class="mb-30 font-sm">If you have shopped with us before, please enter your details below. If you are a new customer, please proceed to the Billing &amp; Shipping section.</p>
                                    <form method="post">
                                        <div class="form-group">
                                            <input type="text" name="email" placeholder="Username Or Email">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" placeholder="Password">
                                        </div>
                                        <div class="login_footer form-group">
                                            <div class="chek-form">
                                                <div class="custome-checkbox">
                                                    <input class="form-check-input" type="checkbox" name="checkbox" id="remember" value="">
                                                    <label class="form-check-label" for="remember"><span>Remember me</span></label>
                                                </div>
                                            </div>
                                            <a href="#">Forgot password?</a>
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn-md" name="login">Log in</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <form method="post" class="apply-coupon">
                                <input type="text" placeholder="Enter Coupon Code...">
                                <button class="btn btn-md" name="login">{{ __('Apply Coupon') }}</button>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <h4 class="mb-30">{{ __('Billing Details') }}</h4>
                        <form action="{{ route('make.payment') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <input type="text" name="name" 
                                    @if (Auth::check()) 
                                        @if (!is_null(Auth::user()->name))
                                            value="{{ Auth::user()->name }}"
                                        @else
                                            placeholder="Input Your First Name"
                                        @endif  
                                    @else 
                                        placeholder="Input Your First Name" 
                                    @endif required="">
                                </div>
                                <div class="form-group col-lg-6">
                                    <input type="text" name="lastName" 
                                    @if (Auth::check()) 
                                        @if (!is_null(Auth::user()->lastName))
                                            value="{{ Auth::user()->lastName }}"
                                        @else
                                            placeholder="Input Your Last Name"
                                        @endif  
                                    @else 
                                        placeholder="Input Your Last Name" 
                                    @endif required="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <input type="text" name="addressLineOne" 
                                    @if (Auth::check()) 
                                        @if (!is_null(Auth::user()->addressLineOne))
                                            value="{{ Auth::user()->addressLineOne }}"
                                        @else
                                            placeholder="Input Your First Address"
                                        @endif  
                                    @else 
                                        placeholder="Input Your First Address" 
                                    @endif required="">
                                </div>
                                <div class="form-group col-lg-6">
                                    <input type="text" name="addressLineTwo" 
                                    @if (Auth::check()) 
                                        @if (!is_null(Auth::user()->addressLineTwo))
                                            value="{{ Auth::user()->addressLineTwo }}"
                                        @else
                                            placeholder="Input Your Second Address [Optional]"
                                        @endif  
                                    @else 
                                        placeholder="Input Your Second Address [Optional]" 
                                    @endif>
                                </div>
                            </div>
                            <div class="row shipping_calculator">
                                <div class="form-group col-lg-4">
                                    <div class="custom_select">
                                        <select name="country_id" id="country_id" class="form-control select-active" required>
                                            <option value="">{{ __('Please Select Country') }}</option>
                                            @foreach ($countries as $country)
                                                @if (Auth::check())
                                                    @if (!is_null(Auth::user()->country_id))
                                                        <option value="{{ $country->id }}" @if ($country->id == Auth::user()->country_id) selected @endif>{{ $country->name }}</option>
                                                    @else
                                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                    @endif
                                                @else
                                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-lg-4">
                                    <div class="custom_select">
                                        <select name="division_id" id="divisions" class="form-control select-active" required>
                                            <option value="" hidden>{{ __('Please Select Division') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-lg-4">
                                    <div class="custom_select">
                                        <select name="district_id" id="districts" class="form-control select-active" required>
                                            <option value="" hidden>{{ __('Please Select District') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <input type="phone" name="phone" 
                                    @if (Auth::check()) 
                                        @if (!is_null(Auth::user()->phone))
                                            value="{{ Auth::user()->phone }}"
                                        @else
                                            placeholder="Input Your Phone No."
                                        @endif  
                                    @else 
                                        placeholder="Input Your Phone No." 
                                    @endif required="">
                                </div>
                                <div class="form-group col-lg-6">
                                    <input type="email" name="email" 
                                    @if (Auth::check()) 
                                        @if (!is_null(Auth::user()->email))
                                            value="{{ Auth::user()->email }}" readonly
                                        @else
                                            placeholder="Input Your Email Address"
                                        @endif
                                    @else 
                                        placeholder="Input Your Email Address" 
                                    @endif required="">
                                </div>
                            </div>
                            <div class="form-group mb-30">
                                <textarea rows="5" name="add_info" placeholder="Additional information"></textarea>
                            </div>
                            {{-- <div class="ship_detail">
                                <div class="form-group">
                                    <div class="chek-form">
                                        <div class="custome-checkbox">
                                            <input class="form-check-input" type="checkbox" name="checkbox" id="differentaddress">
                                            <label class="form-check-label label_info" data-bs-toggle="collapse" data-target="#collapseAddress" href="#collapseAddress" aria-controls="collapseAddress" for="differentaddress"><span>Ship to a different address?</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div id="collapseAddress" class="different_address collapse in">
                                    <div class="row">
                                        <div class="form-group col-lg-6">
                                            <input type="text" required="" name="fname" placeholder="First name *">
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <input type="text" required="" name="lname" placeholder="Last name *">
                                        </div>
                                    </div>
                                    <div class="row shipping_calculator">
                                        <div class="form-group col-lg-6">
                                            <input required="" type="text" name="cname" placeholder="Company Name">
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <div class="custom_select w-100">
                                                <select class="form-control select-active">
                                                    <option value="">Select an option...</option>
                                                    
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-6">
                                            <input type="text" name="billing_address" required="" placeholder="Address *">
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <input type="text" name="billing_address2" required="" placeholder="Address line2">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-6">
                                            <input required="" type="text" name="state" placeholder="State / County *">
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <input required="" type="text" name="city" placeholder="City / Town *">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-6">
                                            <input required="" type="text" name="zipcode" placeholder="Postcode / ZIP *">
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                    </div>
                </div>
                <div class="col-lg-5">
                    @php
                        $totalAmount = 0;
                    @endphp
                    @if (App\Models\Cart::totalItems() == 0)
                    <div class="border p-40 cart-totals ml-30 mb-50">
                        <div class="d-flex align-items-end justify-content-between mb-30">
                            <h4>{{ __('Your Order') }}</h4>
                            <h6 class="text-muted">{{ __('Subtotal') }}</h6>
                        </div>
                        <div class="divider-2 mb-30"></div>
                        <div class="table-responsive order_table checkout">
                            <div class="alert alert-warning">{{ __('No Item Added To Your Cart!!') }}</div>
                        </div>
                    </div>
                    @else
                    <div class="border p-40 cart-totals ml-30 mb-50">
                        <div class="d-flex align-items-end justify-content-between mb-30">
                            <h4>{{ __('Your Order') }}</h4>
                            <h6 class="text-muted">{{ __('Subtotal') }}</h6>
                        </div>
                        <div class="divider-2 mb-30"></div>
                        <div class="table-responsive order_table checkout">
                            <table class="table no-border">
                                <tbody>
                                    @foreach (App\Models\Cart::totalCarts() as $cart)
                                        <tr>
                                            @php $img = 1; @endphp
                                                @if ($cart->product->images->count() > 0)
                                                    <td class="image product-thumbnail"><img src="{{ asset('backend/img/products/' . $cart->product->images->first()->image) }}" alt="#"></td>
                                                @endif
                                            <td>
                                                <h6 class="w-160 mb-5"><a href="{{ route('singleProduct', $cart->product->slug) }}" class="text-heading">{{ $cart->product->name }}</a></h6></span>
                                                <div class="product-rate-cover">
                                                    <div class="product-rate d-inline-block">
                                                        <div class="product-rating" style="width:90%">
                                                        </div>
                                                    </div>
                                                    <span class="font-small ml-5 text-muted"> (4.0)</span>
                                                </div>
                                            </td>
                                            <td>
                                                <h6 class="text-muted pl-20 pr-20">x {{ $cart->product_quantity }}</h6>
                                            </td>
                                            <td>
                                                <h4 class="text-brand">
                                                    @if (!is_null($cart->product->offer_price))
                                                        @php
                                                            $totalSave = ($cart->product->regular_price *($cart->product->offer_price /100) );
                                                            $savedAmount = $cart->product->regular_price - $totalSave;
                                                        @endphp
                                                        {{ $savedAmount }} {{ __('BDT') }}
                                                        @php
                                                            $totalAmount += $savedAmount * $cart->product_quantity;
                                                        @endphp
                                                    @else
                                                        {{ $cart->product->regular_price }} {{ __('BDT') }}
                                                        @php
                                                            $totalAmount += $cart->product->regular_price * $cart->product_quantity;
                                                        @endphp
                                                    @endif
                                                </h4>
                                                <input type="hidden" name="totalQuantity" value="{{ App\Models\Cart::totalItems() }}">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="table-responsive">
                                <table class="table no-border">
                                    <tbody>
                                        <tr>
                                            <td class="cart_total_label">
                                                <h6 class="text-muted">{{ __('Subtotal') }}</h6>
                                            </td>
                                            <td class="cart_total_amount">
                                                <h4 class="text-brand text-end">
                                                    {{ $totalAmount }} {{ __('BDT') }}
                                                </h4>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="cart_total_label">
                                                <h6 class="text-muted">Shipping</h6>
                                            </td>
                                            <td class="cart_total_amount">
                                                <h5 class="text-heading text-end">Free</h4</td> </tr> <tr>
                                            <td class="cart_total_label">
                                                <h6 class="text-muted">Estimate for</h6>
                                            </td>
                                            <td class="cart_total_amount">
                                                <h5 class="text-heading text-end">Bangladesh</h4</td> </tr> <tr>
                                            <td scope="col" colspan="2">
                                                <div class="divider-2 mt-10 mb-10"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="cart_total_label">
                                                <h6 class="text-muted">Total</h6>
                                            </td>
                                            <td class="cart_total_amount">
                                                <h4 class="text-brand text-end">
                                                    {{ $totalAmount }} {{ __('BDT') }}
                                                </h4>
                                                <input type="hidden" name="totalAmount" value="{{ $totalAmount }}">
                                                
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="payment ml-30">
                        <h4 class="mb-30">Payment</h4>
                        <div class="payment_option">
                            <div class="custome-radio">
                                <input class="form-check-input" required="" type="radio" name="payment_method" id="cod" checked="" value="1">
                                <label class="form-check-label" for="cod" data-bs-toggle="collapse" data-target="#checkPayment" aria-controls="checkPayment">Cash On delivery</label>
                            </div>
                            <div class="custome-radio">
                                <input class="form-check-input" required="" type="radio" name="payment_method" id="sslCommerz" value="2">
                                <label class="form-check-label" for="sslCommerz" data-bs-toggle="collapse" data-target="#sslCommerz" aria-controls="sslCommerz">Make Payment (SSL Commerz)</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-fill-out btn-block mt-30">Place an Order<i class="fi-rs-sign-out ml-15"></i></button>
                    </div>
                    @endif
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('pageScripts')
    <script>
        $('#country_id').change(function(){
            var country = $('#country_id').val();
            // Make All The Division As Null
            $('#divisions').html("");
            var option = "";
            $.get("http://127.0.0.1:8000/divisions/" + country, function(data){
                data = JSON.parse(data);
                data.forEach(function(value){
                    option += "<option value=' " + value.id + " '>" + value.name + "</option>";
                });
                $('#divisions').html(option);
            });
        });

        $('#divisions').change(function(){
            var division = $('#divisions').val();
            // Make All The Dsitrict As Null
            $('#districts').html("");
            var option = "";
            $.get("http://127.0.0.1:8000/districts/" + division, function(data){
                data = JSON.parse(data);
                data.forEach(function(value){
                    option += "<option value=' " + value.id + " '>" + value.name + "</option>";
                });
                $('#districts').html(option);
            });
        });
    </script>
@endsection
