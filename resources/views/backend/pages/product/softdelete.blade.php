@extends('backend.layout.template')

@section('title', 'Deleted Products')
@section('body-content')
    <div class="br-pagetitle">
        <i class="icon ion-ios-trash-outline tx-70 lh-0"></i>
        <div>
        <h4>Deleted Products</h4>
        <p class="mg-b-0">Do bigger things with Bracket plus, the responsive bootstrap 4 admin template.</p>
        </div>
    </div><!-- d-flex -->

    <div class="br-pagebody">
        <div class="row row-sm mg-b-20">
            <div class="col-sm-12">
                <div class="card bd-0">
                    <div class="card-header tx-medium bd-0 tx-white">
                        <div class="container">
                            <div class="row">
                                <div class="col text-left">
                                    Soft Deleted Products
                                </div>
                                <div class="col right text-right">
                                    <a href="{{ route('product.manage') }}" class="tx-white"><i class="ion-ios-arrow-left"></i> Manage All Products</a>
                                </div>
                            </div>
                        </div>
                    </div><!-- card-header -->
                    <div class="card-body bd bd-t-0 rounded-bottom">
                        
                        @if ($products->count() == 0)
                            <div class="alert alert-info">No Deleted Products Found!</div>
                        @else
                            <table id="data" class="table table-striped table-hover table-bordered table-responsive-xl">
                                <thead>
                                    <tr>
                                        <th scope="col">#SL.</th>
                                        <th scope="col">Thumbnail</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Brand</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Regular Price</th>
                                        <th scope="col">Offer Price</th>
                                        <th scope="col">Featured</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $serial = 1;
                                    @endphp
                                    @foreach ($products as $product)
                                    <tr>
                                        <th scope="row">{{ $serial }}</th>
                                        <td>
                                            @php $img = 1; @endphp
                                            @foreach ($product->images as $image)
                                                @if ($img > 0)
                                                    <img src="{{ asset('backend/img/products/' . $image->image) }}" class="img-fluid rounded-circle table-image">
                                                    @php $img--; @endphp
                                                @endif
                                                @if (is_null($image->image))
                                                    <img src="{{ asset('backend/img/products/Default.png') }}" alt="" class="img-fluid rounded-circle table-image">
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->brand->name ?? 'N/A' }}</td>
                                        <td>{{ $product->category->name ?? 'N/A' }}</td>
                                        <td>{{ $product->quantity }} Pcs</td>
                                        <td>{{ $product->regular_price }} BDT</td>
                                        <td>
                                            @if (!is_null($product->offer_price))
                                                @php
                                                    $totalSave = ($product->regular_price *($product->offer_price /100) );
                                                @endphp
                                                {{ $product->regular_price - $totalSave }} BDT
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>
                                            @if ($product->is_featured == 0)
                                                <span class="badge badge-warning">Disabled</span>
                                            @elseif ($product->is_featured == 1)
                                                <span class="badge badge-primary">Enabled</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($product->status == 2)
                                                <span class="badge badge-warning">Soft Deleted</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group action-bar" role="group">
                                                <a href="" data-toggle="modal" data-target="#description-{{ $product->id }}"><i class="fas fa-eye"></i></a>
                                                <a href="{{ route('product.edit', $product->id) }}"><i class="fas fa-edit"></i></a>
                                                <a href="" data-toggle="modal" data-target="#fulldelete-{{ $product->id }}"><i class="fas fa-trash"></i></a>
                                            </div>
                                            <!-- View Modal -->
    <div class="modal fade effect-scale modal-dark" id="description-{{ $product->id }}" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content bd-0">
                <div class="modal-header pd-x-20">
                <h5 class="modal-title" id="viewModalLabel"><strong class="tx-inverse tx-medium">Product Name: </strong><span class="text-muted">{{ $product->name }}</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body pd-20">
                    <p class="mg-b-5">
                        <div class="row">
                            <div class="col-lg-4">
                                <table class="table table-striped table-hover table-bordered list-table">
                                    <thead>
                                        <tr>
                                            <th><strong class="tx-inverse tx-medium">Brand:</strong></th>
                                            <td><span class="text-muted">{{ $product->brand->name ?? 'N/A' }}</span></td>
                                        </tr>
                                        <tr>
                                            <th><strong class="tx-inverse tx-medium">Category:</strong></th>
                                            <td><span class="text-muted">{{ $product->category->name ?? 'N/A' }}</span></td>
                                        </tr>
                                        <tr>
                                            <th><strong class="tx-inverse tx-medium">SKU Code:</strong></th>
                                            <td><span class="text-muted">{{ $product->sku_code ?? 'N/A' }}</span></td>
                                        </tr>
                                        <tr>
                                            <th><strong class="tx-inverse tx-medium">Manufacture Date:</strong></th>
                                            <td><span class="text-muted">{{ $product->mfg_date ?? 'N/A' }}</span></td>
                                        </tr>
                                        <tr>
                                            <th><strong class="tx-inverse tx-medium">Expire Date:</strong></th>
                                            <td><span class="text-muted">{{ $product->exp_date ?? 'N/A' }}</span></td>
                                        </tr>
                                        <tr>
                                            <th><strong class="tx-inverse tx-medium">Product Featured:</strong></th>
                                            <td><span class="text-muted">@if ($product->is_featured == 0)
                                                <span>Disabled</span>
                                            @elseif ($product->is_featured == 1)
                                                <span>Enabled</span>
                                            @endif</span>
                                        </td>
                                        </tr>
                                        <tr>
                                            <th><strong class="tx-inverse tx-medium">Product Type:</strong></th>
                                            <td><span class="text-muted">@if ($product->product_type == 0)
                                                <span>Physical</span>
                                            @elseif ($product->product_type == 1)
                                                <span">Digital</span>
                                            @elseif ($product->product_type == 2)
                                                <span">Organic</span>
                                            @endif</span>
                                        </td>
                                        </tr>
                                        <tr>
                                            <th><strong class="tx-inverse tx-medium">Product Tags:</strong></th>
                                            <td><span class="text-muted">{{ $product->product_tags ?? 'N/A' }}</span></td>
                                        </tr>
                                        <tr>
                                            <th><strong class="tx-inverse tx-medium">Status:</strong></th>
                                            <td><span class="text-muted">@if ($product->status == 2)
                                                <span>Soft Deleted</span>
                                            @endif
                                        </td>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <span class="text-muted"><strong class="tx-inverse tx-medium">Quantity: </strong>{{ $product->quantity }} Pcs</span><br>
                                        <hr>
                                    </div>
                                    <div class="col-lg-4">
                                        <span class="text-muted"><strong class="tx-inverse tx-medium">Rglar Price: </strong>{{ $product->regular_price }} BDT</span><br>
                                        <hr>
                                    </div>
                                    <div class="col-lg-4">
                                        <span class="text-muted"><strong class="tx-inverse tx-medium">Offer Price: </strong>@if (!is_null($product->offer_price))
                                                @php
                                                    $totalSave = ($product->regular_price *($product->offer_price /100) );
                                                @endphp
                                                {{ $product->regular_price - $totalSave }} BDT
                                            @else
                                                N/A
                                            @endif
                                        </span><br>
                                        <hr>
                                    </div>
                                </div>
                                <span><strong class="tx-inverse tx-medium">Short Description</strong></span><br>
                                @if (! $product->short_desc)
                                    <span class="text-muted">No Description Added</span>
                                @else
                                <span class="text-muted">{!! Str::substr($product->short_desc, 0, 200) !!}<strong class="tx-inverse tx-medium"> Read More Through Edit...</strong></span><br>
                                @endif
                                <hr>
                                <span><strong class="tx-inverse tx-medium">No Long Description Added</strong></span><br>
                                @if (! $product->long_desc)
                                    <span class="text-muted">No Description Added</span><br>
                                @else
                                <span class="text-muted">{!! Str::substr($product->long_desc, 0, 350) !!} <strong class="tx-inverse tx-medium"> Read More Through Edit...</strong></span><br>
                                @endif
                                <hr>
                                <span><strong class="tx-inverse tx-medium">Additional Info</strong></span><br>
                                @if (! $product->additional_info)
                                    <span class="text-muted">No Info Added</span><br>
                                @else
                                <span class="text-muted">{!! Str::substr($product->additional_info , 0, 250) !!}<strong class="tx-inverse tx-medium"> Read More Through Edit...</strong></span><br>
                                @endif
                                <hr>
                            </div>
                        </div>
                    </p>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                <a href="{{ route('product.edit', $product->id) }}" class="btn btn-teal btn-sm">Update Product</a>
                </div>
            </div>
        </div>
    </div>
                                            
                                            <!-- Full Delete Modal -->
                                            <div class="modal fade effect-scale modal-dark" id="fulldelete-{{ $product->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-sm modal-dialog-centered">
                                                <div class="modal-content bd-0">
                                                    <div class="modal-header pd-x-20">
                                                    <h5 class="modal-title" id="deleteModalLabel">Full Delete This Product</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    </div>
                                                    <div class="modal-body pd-20">
                                                        <p class="mg-b-5">
                                                            Product Will Be Removed Permanently You Wont Be Able To Activate it Back!
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                                                    <form action="{{ route('product.fulldelete', $product->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" name="fullDelete" class="btn btn-danger btn-sm" >Full Delete</button>
                                                    </form>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                        @php
                                            $serial++;
                                        @endphp
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