@extends('backend.layout.template')

@section('title', 'All Orders')
@section('body-content')
    <div class="br-pagetitle">
        <i class="icon ion-ios-list-outline tx-70 lh-0"></i>
        <div>
        <h4>Order Management</h4>
        <p class="mg-b-0">Do bigger things with Bracket plus, the responsive bootstrap 4 admin template.</p>
        </div>
    </div><!-- d-flex -->

    <div class="br-pagebody">
        <div class="row row-sm mg-b-20">
            <div class="col-sm-12">
                <div class="card bd-0">
                    <div class="card-header tx-medium bd-0 tx-white">
                        Manage All Orders
                    </div><!-- card-header -->
                    <div class="card-body bd bd-t-0 rounded-bottom">
                        
                        @if ($orders->count() == 0)
                            <div class="alert alert-info">No Orders Have Been Placed Yet!</div>
                        @else
                            <table id="data" class="table table-striped table-hover table-bordered table-responsive-xl">
                                <thead>
                                    <tr>
                                        <th scope="col">#SL.</th>
                                        <th scope="col">Order Inv</th>
                                        <th scope="col">Customer Nane</th>
                                        <th scope="col">Customer Email</th>
                                        <th scope="col">Order Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $serial = 1;
                                    @endphp
                                    @foreach ($orders as $order)
                                        <tr>
                                            <th scope="row">{{ $serial }}</th>
                                            <td>#{{ $order->inv_id }}</td>
                                            <td>{{ $order->name }} {{ $order->lastName }}</td>
                                            <td>{{ $order->email }}</td>
                                            <td>{{ $order->status }}</td>
                                            <td>
                                                <div class="btn-group action-bar" role="group">
                                                    <a href="{{ route('order.details', $order->id) }}"><i class="fas fa-eye"></i></a>
                                                    <a href=""><i class="fas fa-edit"></i></a>
                                                    <a href="" data-toggle="modal" data-target="#softdelete-"><i class="fas fa-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                        @php $serial++; @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                        
                    </div><!-- card-body -->
                </div><!-- card -->
            </div>
        </div>
    </div>
@endsection