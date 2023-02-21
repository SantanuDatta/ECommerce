@extends('backend.layout.template')

@section('title', 'Order Details')
@section('body-content')
    <div class="br-pagetitle">
        <i class="icon icon ion-ios-paper-outline"></i>
        <div>
            <h4>Order Invoice</h4>
            <p class="mg-b-0">Introducing Bracket Plus admin template, the most handsome admin template of all time.</p>
        </div>
    </div><!-- d-flex -->
    <div class="br-pagebody">

        <div class="card bd-gray-400">
            <div class="card-body pd-30 pd-md-60">
                <div class="d-md-flex justify-content-between flex-row-reverse">
                    <h1 class="mg-b-0 tx-uppercase tx-gray-400 tx-mont tx-bold">Invoice - #{{ $order->inv_id }}</h1>
                    <div class="mg-t-25 mg-md-t-0">
                        @foreach ($settings as $setting)
                            <h6 class="tx-teal tx-uppercase tx-bold">{{ $setting->site_title }}</h6>
                            <p class="lh-7">
                                Tel No: {{ $setting->phone_no ?? 'N/A' }}<br>
                                Email: {{ $setting->email ?? 'N/A' }}</p>
                        @endforeach

                    </div>
                </div><!-- d-flex -->

                <div class="row mg-t-20">
                    <div class="col-md">
                        <label class="tx-uppercase tx-13 tx-bold mg-b-20">Billed To</label>
                        <h6 class="tx-white">{{ $order->name }} {{ $order->lastName }}</h6>
                        <p class="lh-7">{{ $order->address_1 }}, {{ $order->district->name ?? 'N/A' }},
                            {{ $order->division->name ?? 'N/A' }}, {{ $order->country->name ?? 'N/A' }} <br>
                            Tel No: {{ $order->phone }}<br>
                            Email: {{ $order->email }}</p>
                    </div><!-- col -->
                    <div class="col-md">
                        <label class="tx-uppercase tx-13 tx-bold mg-b-20">Invoice Information</label>
                        <p class="d-flex justify-content-between mg-b-5">
                            <span>Invoice No</span>
                            <span class="tx-teal"># {{ $order->inv_id }}</span>
                        </p>
                        <p class="d-flex justify-content-between mg-b-5">
                            <span>Payment Method</span>
                            @if ($order->payment_method == 1)
                                <span class="tx-teal">Cash On Delivery</span>
                            @elseif ($order->payment_method == 2)
                                <span class="tx-teal">Through SSL Commerz</span>
                            @endif
                        </p>
                        <p class="d-flex justify-content-between mg-b-5">
                            <span>Transaction Id:</span>
                            <span class="tx-teal">{{ $order->transaction_id }}</span>
                        </p>
                        <p class="d-flex justify-content-between mg-b-5">
                            <span>Issue Date:</span>
                            <span class="tx-teal">{{ $order->created_at->toFormattedDateString() }}</span>
                        </p>
                        <p class="d-flex justify-content-between mg-b-5">
                            <span>Order Status:</span>
                            <span class="tx-teal">
                                @if ($order->status == 1)
                                    Pending
                                @elseif ($order->status == 2)
                                    Proceesing
                                @elseif ($order->status == 3)
                                    Success
                                @elseif ($order->status == 4)
                                    Failed
                                @elseif ($order->status == 5)
                                    Cancelled
                                @endif
                            </span>
                        </p>
                        <form action="{{ route('order.update', $order->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="">Manage Order Status</label>
                                <select class="form-control form-control-dark" name="status" id="">
                                    <option value="1" @if ($order->status == 1) selected @endif>Pending
                                    </option>
                                    <option value="2" @if ($order->status == 2) selected @endif>Proceesing
                                    </option>
                                    <option value="3" @if ($order->status == 3) selected @endif>Success
                                    </option>
                                    <option value="4" @if ($order->status == 4) selected @endif>Failed
                                    </option>
                                    <option value="5" @if ($order->status == 5) selected @endif>Cancelled
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="updateStatus" class="btn btn-teal float-right">Update
                                    Order</button>
                            </div>
                        </form>
                    </div><!-- col -->

                </div><!-- row -->

                <div class="table-responsive mg-t-40">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="wd-20p">#SL.</th>
                                <th class="wd-40p">Prduct Name</th>
                                <th class="tx-center">QNTY</th>
                                <th class="tx-right">Unit Price</th>
                                <th class="tx-right">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total = collect($order->amount)->sum();
                            @endphp
                            @php
                                $serial = 1;
                            @endphp
                            @foreach ($carts as $cart)
                                <tr>
                                    <td>{{ $serial }}</td>
                                    <td class="tx-12">{{ $cart->product->name }}<br><small>SKU:
                                            {{ $cart->product->sku_code ?? 'N/A' }}</small></td>
                                    <td class="tx-center">{{ $cart->product_quantity }}</td>
                                    <td class="tx-right">{{ $cart->unit_price }} {{ __('BDT') }}</td>
                                    <td class="tx-right">{{ $cart->unit_price * $cart->product_quantity }}
                                        {{ __('BDT') }}</td>
                                </tr>
                                @php $serial++; @endphp
                            @endforeach

                            <td colspan="2" rowspan="4" class="valign-middle">
                                <div class="mg-r-20">
                                    <label class="tx-uppercase tx-13 tx-bold mg-b-10">Additional Information</label>
                                    <p class="tx-13">{{ $order->add_info ?? 'No Added Information By Customer!' }}</p>
                                </div>
                            </td>
                            <td class="tx-right">Sub-Total</td>
                            <td colspan="2" class="tx-right">{{ $total }} {{ 'BDT' }}</td>
                            </tr>
                            <tr>
                                <td class="tx-right">Tax (5%)</td>
                                <td colspan="2" class="tx-right">0</td>
                            </tr>
                            <tr>
                                @if ($order->payment_method == 1)
                                    <td class="tx-right tx-uppercase tx-medium tx-white">
                                        @if ($order->status == 3)
                                            Amount Has Been Payed
                                        @else
                                            Total Due
                                        @endif
                                    </td>
                                    <td colspan="2" class="tx-right">
                                        <h4 class="tx-teal tx-bold tx-lato">{{ $total }} {{ 'BDT' }}</h4>
                                    </td>
                                @elseif ($order->payment_method == 2)
                                    <td class="tx-right tx-uppercase tx-medium tx-white">Total Amount Paid</td>
                                    <td colspan="2" class="tx-right">
                                        <h4 class="tx-teal tx-bold tx-lato">{{ $total }} {{ 'BDT' }}</h4>
                                    </td>
                                @endif
                        </tbody>
                    </table>
                </div><!-- table-responsive -->

                <hr class="mg-b-60 bd-white-1">

                {{-- <a href="" class="btn btn-primary btn-block">Pay Now</a> --}}

            </div><!-- card-body -->
        </div><!-- card -->

    @endsection
