@extends('frontend.layout.template')

@section('title', 'Invoice')
@section('body-content')
    <div class="invoice invoice-content invoice-4">
        <div class="back-top-home hover-up mt-30 ml-30">
            <a class="hover-up" href="index.html"><i class="fi-rs-home mr-5"></i> Homepage</a>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="invoice-inner">
                        <div class="invoice-info" id="invoice_wrapper">
                            <div class="invoice-header">
                                <div class="row">
                                    <div class="col-lg-4 col-md-6">
                                        <div class="logo">
                                            <a href="index.html"><img src="{{ asset('frontend/assets/imgs/theme/logo.svg') }}" alt="logo" /></a>
                                        </div>
                                        <p class="invoice-addr-1 mt-10">
                                            <strong>Invoice Numb:</strong> <strong class="text-brand">#{{ $orderHistory->inv_id }}</strong> <br />
                                            <strong>Invoice Data:</strong> {{ $orderHistory->created_at->toFormattedDateString() }} 
                                        </p>
                                    </div>
                                    @php
                                        $total = collect($orderHistory->amount)->sum();;
                                    @endphp 
                                    <div class="col-lg-4 offset-4">
                                        <div class="invoice-number">
                                            <h4 class="invoice-title-1 mb-10">Invoice To</h4>
                                            <p class="invoice-addr-1">
                                                <strong class="text-brand">{{ $orderHistory->name }} {{ $orderHistory->lastName }}</strong> <br />
                                                {{ $orderHistory->address_1 }}
                                                {{ $orderHistory->address_2 }}<br />
                                                <abbr title="Phone">Phone:</abbr> {{ $orderHistory->phone }}<br />
                                                <abbr title="Email">Email: </abbr><a href="mailto::{{ $orderHistory->email }}" class="__cf_email__">{{ $orderHistory->email }}</a><br />
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
                                            @foreach (App\Models\Cart::orderBy('id', 'asc')->where('order_id', $orderHistory->id)->get() as $item)
                                                <tr>
                                                    <td>
                                                        <div class="item-desc-1">
                                                            <span>{{ $item->product->name }}</span>
                                                            <small>SKU: {{ $item->product->sku_code ?? 'N/A' }}</small>
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
                                            <tr>
                                                <td colspan="3" class="text-end f-w-600">Grand Total</td>
                                                <td class="text-right f-w-600">{{ $total }} {{ ('BDT') }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="invoice-bottom pb-80">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="mb-15">Payment Method</h6>
                                        <p class="font-sm">
                                            @if ($orderHistory->payment_method == 1)
                                                <strong>Cash On Delivery</strong>
                                            @elseif ($orderHistory->payment_method == 2)
                                                <strong>Paid Through SSL Commerz</strong><br>
                                                <strong>Transaction Id:</strong> {{ $orderHistory->transaction_id }}
                                            @endif
                                        </p>
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <h6 class="mb-15">Total Amount</h6>
                                        <h3 class="mt-0 mb-0 text-brand">{{ $total }} {{ ('BDT') }}</h3>
                                        <p class="mb-0 text-muted">Taxes Included</p>
                                    </div>
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
    
    