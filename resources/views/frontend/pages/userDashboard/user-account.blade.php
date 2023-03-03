@extends('frontend.layout.template')

@section('title', 'User Account')
@section('body-content')
    <main class="main pages">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{ route('home') }}" rel="nofollow"><i class="fi-rs-home mr-5"></i>{{ __('Home') }}</a>
                    <span></span> {{ __('My Account') }}
                </div>
            </div>
        </div>
        <div class="page-content pt-150 pb-150">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 m-auto">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="dashboard-menu">
                                    <ul class="nav flex-column" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="dashboard-tab" data-bs-toggle="tab"
                                                href="#dashboard" role="tab" aria-controls="dashboard"
                                                aria-selected="false"><i
                                                    class="fi-rs-settings-sliders mr-10"></i>{{ __('Dashboard') }}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="orders-tab" data-bs-toggle="tab" href="#orders"
                                                role="tab" aria-controls="orders" aria-selected="false"><i
                                                    class="fi-rs-shopping-bag mr-10"></i>{{ __('Orders') }}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="track-orders-tab" data-bs-toggle="tab"
                                                href="#track-orders" role="tab" aria-controls="track-orders"
                                                aria-selected="false"><i
                                                    class="fi-rs-shopping-cart-check mr-10"></i>{{ __('Track Your Order') }}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="address-tab" data-bs-toggle="tab" href="#address"
                                                role="tab" aria-controls="address" aria-selected="true"><i
                                                    class="fi-rs-marker mr-10"></i>{{ __('My Address') }}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="account-detail-tab" data-bs-toggle="tab"
                                                href="#account-detail" role="tab" aria-controls="account-detail"
                                                aria-selected="true"><i
                                                    class="fi-rs-user mr-10"></i>{{ __('Account details') }}</a>
                                        </li>
                                        <li class="nav-item">
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <a class="nav-link" href="{{ route('logout') }}"
                                                    onclick="event.preventDefault(); this.closest('form').submit();"><i
                                                        class="fi-rs-sign-out mr-10"></i>{{ __('Logout') }}</a>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="tab-content account dashboard-content pl-50">
                                    <div class="tab-pane fade active show" id="dashboard" role="tabpanel"
                                        aria-labelledby="dashboard-tab">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="mb-0">{{ __('Hello,') }} {{ Auth::user()->name }}
                                                    {{ Auth::user()->lastName }}</h3>
                                            </div>
                                            <div class="card-body">
                                                <p>
                                                    {{ __('From your account dashboard. you can easily check & view your') }}
                                                    <a href="#orders">{{ __('recent orders') }}</a>,<br />
                                                    {{ __('manage your') }} <a
                                                        href="#">{{ __('shipping and billing addresses') }}</a>
                                                    {{ __('and') }} <a
                                                        href="#">{{ __('edit your password and account details.') }}</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="mb-0">Your Orders</h3>
                                            </div>
                                            <div class="card-body">
                                                @if ($orderHistory->count() == 0)
                                                    <div class="alert alert-info">
                                                        {{ __('You Havent Ordered Anything Yet!') }}</div>
                                                @else
                                                    <div class="table-responsive">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Invoice ID</th>
                                                                    <th>Date</th>
                                                                    <th>Status</th>
                                                                    <th>Total</th>
                                                                    <th>Actions</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @if (Auth::check())
                                                                    @foreach ($orderHistory as $item)
                                                                        <tr>
                                                                            <td>#{{ $item->inv_id }}</td>
                                                                            <td>{{ $item->created_at->toFormattedDateString() }}
                                                                            </td>
                                                                            <td>
                                                                                @if ($item->status == 1)
                                                                                    Pending
                                                                                @elseif ($item->status == 2)
                                                                                    Proceesing
                                                                                @elseif ($item->status == 3)
                                                                                    Success
                                                                                @elseif ($item->status == 4)
                                                                                    Failed
                                                                                @elseif ($item->status == 5)
                                                                                    Cancelled
                                                                                @endif
                                                                            </td>
                                                                            <td>{{ $item->amount }} {{ __('BDT') }}
                                                                                for {{ $item->total_quantity }} item</td>
                                                                            <td><a href="{{ route('invoice', $item->inv_id) }}"
                                                                                    class="btn-small d-block">View</a></td>
                                                                        </tr>
                                                                    @endforeach
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="track-orders" role="tabpanel"
                                        aria-labelledby="track-orders-tab">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="mb-0">Orders tracking</h3>
                                            </div>
                                            <div class="card-body contact-from-area">
                                                <p>To track your order please enter your OrderID in the box below and press
                                                    "Track" button. This was given to you on your receipt and in the
                                                    confirmation email you should have received.</p>
                                                <div class="row">
                                                    <div class="col-lg-8">
                                                        <form class="contact-form-style mt-30 mb-50" action="#"
                                                            method="post">
                                                            <div class="input-style mb-20">
                                                                <label>Order ID</label>
                                                                <input name="order-id"
                                                                    placeholder="Found in your order confirmation email"
                                                                    type="text" />
                                                            </div>
                                                            <div class="input-style mb-20">
                                                                <label>Billing email</label>
                                                                <input name="billing-email"
                                                                    placeholder="Email you used during checkout"
                                                                    type="email" />
                                                            </div>
                                                            <button class="submit submit-auto-width"
                                                                type="submit">Track</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="address" role="tabpanel"
                                        aria-labelledby="address-tab">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="card mb-3 mb-lg-0">
                                                    <div class="card-header">
                                                        <h3 class="mb-0">Billing Address</h3>
                                                    </div>
                                                    <div class="card-body">
                                                        <address>
                                                            3522 Interstate<br />
                                                            75 Business Spur,<br />
                                                            Sault Ste. <br />Marie, MI 49783
                                                        </address>
                                                        <p>New York</p>
                                                        <a href="#" class="btn-small">Edit</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5 class="mb-0">Shipping Address</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <address>
                                                            4299 Express Lane<br />
                                                            Sarasota, <br />FL 34249 USA <br />Phone: 1.941.227.4444
                                                        </address>
                                                        <p>Sarasota</p>
                                                        <a href="#" class="btn-small">Edit</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="account-detail" role="tabpanel"
                                        aria-labelledby="account-detail-tab">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>Account Details</h5>
                                            </div>
                                            <div class="card-body">
                                                <form action="{{ route('user.update', Auth::user()->id) }}"
                                                    method="POST" name="enq">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="form-group col-md-6">
                                                            <label>First Name <span class="required">*</span></label>
                                                            <input class="form-control" name="name" type="text"
                                                                value="{{ Auth::user()->name }}" required="" />
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>Last Name <span class="required">*</span></label>
                                                            <input class="form-control" name="lastName" type="text"
                                                                @if (!is_null(Auth::user()->lastName)) value="{{ Auth::user()->lastName }}" @else placeholder="Input Your Last Name" @endif />
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>Email Address <span class="required">*</span></label>
                                                            <input class="form-control" name="email" type="email"
                                                                value="{{ Auth::user()->email }}" readonly />
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>Phone No. <span class="required">*</span></label>
                                                            <input class="form-control" name="phone" type="phone"
                                                                @if (!is_null(Auth::user()->phone)) value="{{ Auth::user()->phone }}" @else placeholder="Enter Your Phone No." @endif />
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>Address Line 1 <span class="required">*</span></label>
                                                            <input class="form-control" name="addressLineOne"
                                                                type="text"
                                                                @if (!is_null(Auth::user()->addressLineOne)) value="{{ Auth::user()->addressLineOne }}" @else placeholder="Input Your First Address" @endif />
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>Address Line 2 [Optional]</label>
                                                            <input class="form-control" name="addressLineTwo"
                                                                type="text"
                                                                @if (!is_null(Auth::user()->addressLineTwo)) value="{{ Auth::user()->addressLineTwo }}" @else placeholder="Input Your Second Address" @endif />
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label>Country <span class="required">*</span></label>
                                                            <select name="country_id" id="country_id"
                                                                class="form-control">
                                                                <option value="" hidden>Please Select Country
                                                                </option>
                                                                @foreach ($countries as $country)
                                                                    <option value="{{ $country->id }}"
                                                                        @if ($country->id == Auth::user()->country_id) selected @endif>
                                                                        {{ $country->name }}</option>
                                                                @endforeach
                                                            </select>

                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label>Division <span class="required">*</span></label>
                                                            <select name="division_id" id="divisions"
                                                                class="form-control">
                                                                <option value="" hidden>Please Select Division
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label>District <span class="required">*</span></label>
                                                            <select name="district_id" class="form-control"
                                                                id="districts">
                                                                <option value="" hidden>Please Select District
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <button type="submit"
                                                                class="btn btn-fill-out submit font-weight-bold"
                                                                name="submit" value="Submit">Save Change</button>
                                                        </div>
                                                    </div>
                                                </form>
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

@push('extraScripts')
    @include('frontend.includes.extraScript.dropdownAjax')
@endpush
