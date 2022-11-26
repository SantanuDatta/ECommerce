@extends('backend.layout.template')

@section('title', 'Order Details')
@section('body-content')
<div class="br-pagetitle">
    <i class="icon icon ion-ios-paper-outline"></i>
    <div>
        <h4>Page Invoice</h4>
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
                    <h6 class="tx-primary">{{ $setting->site_title }}</h6>
                    <p class="lh-7">
                    Tel No: {{ $setting->phone_no ?? 'N/A'}}<br>
                    Email: {{ $setting->email ?? 'N/A'}}</p>
                @endforeach
                
            </div>
        </div><!-- d-flex -->

        <div class="row mg-t-20">
            <div class="col-md">
                <label class="tx-uppercase tx-13 tx-bold mg-b-20">Billed To</label>
                <h6 class="tx-white">{{ $order->name }} {{ $order->lastName }}</h6>
                <p class="lh-7">{{ $order->address_1 }}, {{ $order->district->name }}, {{ $order->division->name }}, {{ $order->country->name }} <br>
                Tel No: {{ $order->phone }}<br>
                Email: {{ $order->email }}</p>
            </div><!-- col -->
            <div class="col-md">
                <label class="tx-uppercase tx-13 tx-bold mg-b-20">Invoice Information</label>
                <p class="d-flex justify-content-between mg-b-5">
                    <span>Invoice No</span>
                    <span># {{ $order->inv_id }}</span>
                </p>
                <p class="d-flex justify-content-between mg-b-5">
                    <span>Transaction Id:</span>
                    <span>{{ $order->transaction_id }}</span>
                </p>
                <p class="d-flex justify-content-between mg-b-5">
                    <span>Issue Date:</span>
                    <span>{{ $order->created_at->toFormattedDateString() }}</span>
                </p>
                <p class="d-flex justify-content-between mg-b-5">
                    <span>Order Status:</span>
                    <span>{{ $order->status }}</span>
                </p>
                    <form action="" method="POST">
                        <div class="form-group">
                            <label for="">Manage Order Status</label>
                            <select class="form-control form-control-dark" name="status" id="">
                                <option value="Proccesing">Proccesing</option>
                                <option value="On Hold">On Hold</option>
                                <option value="Success">Success</option>
                                <option value="Canceled">Canceled</option>
                                <option value="Refund">Refund</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="submit" name="updateStatus" class="btn btn-teal float-right">Update Order</button>
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
                        <td class="tx-12">{{ $cart->product->name }}<br><small>SKU: {{ $cart->product->sku_code ?? 'N/A' }}</small></td>
                        <td class="tx-center">{{ $cart->product_quantity }}</td>
                        <td class="tx-right">{{ $cart->unit_price }} {{ __('BDT') }}</td>
                        <td class="tx-right">{{ $cart->unit_price * $cart->product_quantity }} {{ __('BDT') }}</td>
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
                <td colspan="2" class="tx-right">{{ $total }} {{ ('BDT') }}</td>
                </tr>
                <tr>
                <td class="tx-right">Tax (5%)</td>
                <td colspan="2"  class="tx-right">0</td>
                </tr>
                <tr>
                <td class="tx-right tx-uppercase tx-medium tx-white">Total Due</td>
                <td colspan="2" class="tx-right"><h4 class="tx-teal tx-bold tx-lato">{{ $total }} {{ ('BDT') }}</h4></td>
                </tr>
            </tbody>
            </table>
        </div><!-- table-responsive -->

        <hr class="mg-b-60 bd-white-1">

        {{-- <a href="" class="btn btn-primary btn-block">Pay Now</a> --}}

        </div><!-- card-body -->
    </div><!-- card -->

@endsection