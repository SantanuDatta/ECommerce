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
                            <table id="data"
                                class="table table-striped table-hover table-bordered table-responsive-xl">
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
                                            <td>
                                                @if ($order->status == 1)
                                                    <span class="badge badge-info">Pending</span>
                                                @elseif ($order->status == 2)
                                                    <span class="badge badge-primary">Proceesing</span>
                                                @elseif ($order->status == 3)
                                                    <span class="badge badge-success">Success</span>
                                                @elseif ($order->status == 4)
                                                    <span class="badge badge-warning">Failed</span>
                                                @elseif ($order->status == 5)
                                                    <span class="badge badge-danger">Cancelled</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group action-bar" role="group">
                                                    <a href="{{ route('order.details', $order->id) }}"><i
                                                            class="fas fa-eye"></i></a>
                                                    <a href="" data-toggle="modal"
                                                        data-target="#deleteOrder-{{ $order->id }}"><i
                                                            class="fas fa-trash"></i></a>
                                                </div>

                                                <!-- Delete Modal -->
                                                <div class="modal fade effect-scale modal-dark"
                                                    id="deleteOrder-{{ $order->id }}" tabindex="-1"
                                                    aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-sm modal-dialog-centered">
                                                        <div class="modal-content bd-0">
                                                            <div class="modal-header pd-x-20">
                                                                <h5 class="modal-title" id="deleteModalLabel">Delete Order
                                                                </h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body pd-20">
                                                                <p class="mg-b-5">
                                                                    This Order Will Be Removed Completely
                                                                </p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary btn-sm"
                                                                    data-dismiss="modal">Close</button>
                                                                <form action="{{ route('order.destroy', $order->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <button type="submit" name="status"
                                                                        class="btn btn-danger btn-sm">Delete Order</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
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
