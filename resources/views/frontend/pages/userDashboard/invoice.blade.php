@extends('frontend.layout.template')

@section('title', 'Success')
@section('body-content')
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="{{ route('home') }}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                <span></span> <a href="{{ route('user.dashboard') }}" rel="nofollow"></i>My Acount</a>
                <span></span> Successful Order
            </div>
        </div>
    </div>
    <div class="invoice invoice-content invoice-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="invoice-inner">
                        <div class="invoice-info" id="invoice_wrapper">
                            <div class="invoice-header">
                                <div class="row">
                                    <div class="col-lg-4 col-md-6">
                                        <div class="logo">
                                            @foreach ($settings as $setting)
                                                <a href="{{ route('home') }}"><img src="{{ asset('backend/img/settings/logo/'.$setting->logo) }}" alt="logo" /></a>
                                            @endforeach
                                        </div>
                                        <p class="invoice-addr-1 mt-10">
                                            <strong>Invoice Numb:</strong> <strong class="text-brand">#{{ $inv->inv_id }}</strong> <br />
                                            <strong>Invoice Data:</strong> {{ $inv->created_at->toFormattedDateString() }} 
                                        </p>
                                    </div>
                                    @php
                                        $total = collect($inv->amount)->sum();
                                    @endphp 
                                    <div class="col-lg-4 offset-4">
                                        <div class="invoice-number">
                                            <h4 class="invoice-title-1 mb-10">Invoice To</h4>
                                            <p class="invoice-addr-1">
                                                <strong class="text-brand">{{ $inv->name }} {{ $inv->lastName }}</strong> <br />
                                                {{ $inv->address_1 }}
                                                {{ $inv->address_2 }}<br />
                                                <abbr title="Phone">Phone:</abbr> {{ $inv->phone }}<br />
                                                <abbr title="Email">Email: </abbr><a href="mailto::{{ $inv->email }}" class="__cf_email__">{{ $inv->email }}</a><br />
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="invoice-center">
                                <div class="table-responsive">
                                    <table class="table table-striped invoice-table">
                                        <thead class="bg-active">
                                            <tr>
                                                <th>Item Item</th>
                                                <th class="text-center">Unit Price</th>
                                                <th class="text-center">Quantity</th>
                                                <th class="text-right">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach (App\Models\Cart::orderBy('id', 'asc')->where('order_id', $inv->id)->get() as $item)
                                                <tr>
                                                    <td>
                                                        <div class="item-desc-1">
                                                            <span>{{ $item->product->name }}</span>
                                                            <small>SKU: {{ $item->product->sku_code ?? 'N/A' }}</small>
                                                            @if ( $inv->status == 3 && Auth::check())
                                                                @if (is_null(App\Models\ProductReview::where('user_id', Auth::user()->id)->where('product_id', $item->product_id)->first()))
                                                                    <span><a href="" data-bs-toggle="modal" data-bs-target="#productReview-{{ $item->product_id }}">Review This Product</a></span>
                                                                @else
                                                                    <span><a href="" data-bs-toggle="modal" data-bs-target="#updateReview-{{ $item->product_id }}">Update This Product Review</a></span>
                                                                @endif
                                                            @endif
                                                            <!--Review Modal -->
                                                            <div class="modal fade" id="productReview-{{ $item->product_id }}" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h1 class="modal-title fs-5" id="reviewModalLabel">{{ $item->product->name }}</h1>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <form action="{{ route('product.review') }}" method="POST">
                                                                                @csrf
                                                                                <div class="form-group">
                                                                                    <label for="">Review Product</label><br>
                                                                                    <ul class="rate-area">
                                                                                        <input type="radio" id="5-star-{{ $item->product_id }}" name="rating" value="5"/>
                                                                                        <label for="5-star-{{ $item->product_id }}" title="Amazing">5 stars</label>
                                                                                        <input type="radio" id="4-star-{{ $item->product_id }}" name="rating" value="4"/>
                                                                                        <label for="4-star-{{ $item->product_id }}" title="Good">4 stars</label>
                                                                                        <input type="radio" id="3-star-{{ $item->product_id }}" name="rating" value="3"/>
                                                                                        <label for="3-star-{{ $item->product_id }}" title="Average">3 stars</label>
                                                                                        <input type="radio" id="2-star-{{ $item->product_id }}" name="rating" value="2"/>
                                                                                        <label for="2-star-{{ $item->product_id }}" title="Not Good">2 stars</label>
                                                                                        <input type="radio" id="1-star-{{ $item->product_id }}" name="rating" value="1"/>
                                                                                        <label for="1-star-{{ $item->product_id }}" title="Bad">1 star</label>
                                                                                    </ul>
                                                                                </div>
                                                                                <div class="form-group"><br>
                                                                                    <label for="">Your Experience</label>
                                                                                    <textarea name="comment" id="" cols="30" rows="10" placeholder="You FeedBack Matters"></textarea>
                                                                                </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                                                                            <input type="submit" class="btn btn-primary" name="review" value="Review Product">
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- Update Review -->
                                                            @foreach ( App\Models\ProductReview::where('user_id', Auth::user()->id)->where('product_id', $item->product->id)->get() as $review )
                                                                <div class="modal fade" id="updateReview-{{ $item->product_id }}" tabindex="-1" aria-labelledby="updateReviewModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h1 class="modal-title fs-5" id="updateReviewModalLabel">{{ $item->product->name }}</h1>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <form action="{{ route('update.review', $review->id) }}" method="POST">
                                                                                    @csrf
                                                                                    <div class="form-group">
                                                                                        <label for="">Review Product</label><br>
                                                                                        <ul class="rate-area">
                                                                                            <input type="radio" id="5-star-{{ $item->product_id }}-review-{{ $review->id }}" name="rating" value="5"@if ($review->rating == 5) checked @endif/>
                                                                                            <label for="5-star-{{ $item->product_id }}-review-{{ $review->id }}" title="Amazing">5 stars</label>
                                                                                            <input type="radio" id="4-star-{{ $item->product_id }}-review-{{ $review->id }}" name="rating" value="4"@if ($review->rating == 4) checked @endif/>
                                                                                            <label for="4-star-{{ $item->product_id }}-review-{{ $review->id }}" title="Good">4 stars</label>
                                                                                            <input type="radio" id="3-star-{{ $item->product_id }}-review-{{ $review->id }}" name="rating" value="3"@if ($review->rating == 3) checked @endif/>
                                                                                            <label for="3-star-{{ $item->product_id }}-review-{{ $review->id }}" title="Average">3 stars</label>
                                                                                            <input type="radio" id="2-star-{{ $item->product_id }}-review-{{ $review->id }}" name="rating" value="2"@if ($review->rating == 2) checked @endif/>
                                                                                            <label for="2-star-{{ $item->product_id }}-review-{{ $review->id }}" title="Not Good">2 stars</label>
                                                                                            <input type="radio" id="1-star-{{ $item->product_id }}-review-{{ $review->id }}" name="rating" value="1"@if ($review->rating == 1) checked @endif/>
                                                                                            <label for="1-star-{{ $item->product_id }}-review-{{ $review->id }}" title="Bad">1 star</label>
                                                                                        </ul>
                                                                                    </div>
                                                                                    <div class="form-group"><br>
                                                                                        <label for="">Your Experience</label>
                                                                                        <textarea name="comment" id="" cols="30" rows="10" placeholder="You FeedBack Matters">{{ $review->comment }}</textarea>
                                                                                    </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <input type="submit" class="btn btn-primary" name="review" value="Review Product">
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </td>
                                                    <td class="text-center">{{ $item->unit_price }} {{ __('BDT') }}</td>
                                                    <td class="text-center">{{ $item->product_quantity }}</td>
                                                    <td class="text-right">{{ $item->unit_price * $item->product_quantity }} {{ __('BDT') }}</td>
                                                </tr>
                                            @endforeach
                                            
                                            <tr>
                                                <td colspan="3" class="text-end f-w-600">SubTotal</td>
                                                <td class="text-right">{{ $total }} {{ ('BDT') }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="text-end f-w-600">Tax</td>
                                                <td class="text-right">0 {{ __('BDT') }}</td>
                                            </tr>
                                            @if ($inv->payment_method == 1)
                                                <tr>
                                                    <td colspan="3" class="text-end f-w-600">
                                                        @if ($inv->status == 3)
                                                            Total Amount Paid
                                                        @else
                                                            Total Due
                                                        @endif
                                                    </td>
                                                    <td class="text-right f-w-600">{{ $total }} {{ ('BDT') }}</td>
                                                </tr>
                                                @elseif ($inv->payment_method == 2)
                                                <tr>
                                                    <td colspan="3" class="text-end f-w-600">Total Amount Paid</td>
                                                    <td class="text-right f-w-600">{{ $total }} {{ ('BDT') }}</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="invoice-bottom pb-80">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="mb-15">Payment Method</h6>
                                        <p class="font-sm">
                                            @if ($inv->payment_method == 1)
                                                <strong>Cash On Delivery</strong>
                                            @elseif ($inv->payment_method == 2)
                                                <strong>Paid Through SSL Commerz</strong><br>
                                                <strong>Transaction Id: <u class="text-brand">{{ $inv->transaction_id }}</u></strong> 
                                            @endif
                                        </p>
                                    </div>
                                    @if ($inv->payment_method == 1)
                                        <div class="col-md-6 text-end">
                                            <h6 class="mb-15">
                                                @if ($inv->status == 3)
                                                    Amount Has Been Paid
                                                @else
                                                    Amount To Be Paid
                                                @endif
                                            </h6>
                                            <h3 class="mt-0 mb-0 text-brand">{{ $total }} {{ ('BDT') }}</h3>
                                            <p class="mb-0 text-muted">Taxes Included</p>
                                        </div>
                                    @elseif ($inv->payment_method == 2)
                                        <div class="col-md-6 text-end">
                                            <h6 class="mb-15">Total Amount</h6>
                                            <h3 class="mt-0 mb-0 text-brand">{{ $total }} {{ ('BDT') }}</h3>
                                            <p class="mb-0 text-muted">Taxes Included</p>
                                        </div>
                                    @endif
                                </div>
                                <div class="row text-center">
                                    <div class="hr mt-30 mb-30"></div>
                                    <p class="mb-0">
                                        <strong>Note:</strong>This is computer generated receipt and does not require physical signature.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="invoice-btn-section clearfix d-print-none">
                            <a href="javascript:window.print()" class="btn btn-lg btn-custom btn-print hover-up"> <img src="{{ asset('frontend/assets/imgs/theme/icons/icon-print.svg') }}" alt="" /> Print </a>
                            <a id="invoice_download_btn" class="btn btn-lg btn-custom btn-download hover-up"> <img src="{{ asset('frontend/assets/imgs/theme/icons/icon-download.svg') }}" alt="" /> Download </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
@endsection