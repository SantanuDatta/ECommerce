@extends('backend.layout.template')

@section('title', 'Edit Product')
@section('body-content')
    <div class="br-pagetitle">
        <i class="icon ion-ios-plus-outline tx-70 lh-0"></i>
        <div>
            <h4>Update Product</h4>
            <p class="mg-b-0">Do bigger things with Bracket plus, the responsive bootstrap 4 admin template.</p>
        </div>
    </div><!-- d-flex -->

    <div class="br-pagebody">
        <div class="row row-sm mg-b-20">
            <div class="col-sm-12">
                <div class="card bd-0">
                    <div class="card-header tx-medium bd-0 tx-white">
                        Edit Product
                    </div><!-- card-header -->
                    <div class="card-body bd bd-t-0 rounded-bottom">
                        <form action="{{ route('product.update', $product->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <label for="">Product Name</label>
                                        <input type="text" class="form-control form-control-dark" name="name"
                                            value="{{ $product->name }}" required>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="">Select Brand</label>
                                                <select name="brand_id" class="form-control form-control-dark select2"
                                                    id="">
                                                    <option value="" hidden>Select A Brand</option>
                                                    @foreach ($brands as $brand)
                                                        <option value="{{ $brand->id }}"
                                                            @if ($brand->id == $product->brand_id) selected @endif>
                                                            {{ $brand->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="">Select Category</label>
                                                <select name="category_id" class="form-control form-control-dark select2"
                                                    id="">
                                                    <option value="" hidden>Select A Category</option>
                                                    @foreach ($parentCat as $pCat)
                                                        <option value="{{ $pCat->id }}"
                                                            @if ($pCat->id == $product->category_id) selected @endif>
                                                            {{ $pCat->name }}</option>
                                                        @foreach (App\Models\Category::orderBy('name', 'asc')->where('is_parent', $pCat->id)->get() as $childCat)
                                                            <option value="{{ $childCat->id }}"
                                                                @if ($childCat->id == $product->category_id) selected @endif>&#8627;
                                                                {{ $childCat->name }}</option>
                                                        @endforeach
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="">Manufacturing Date</label>
                                                <div class="input-group input-group-dark">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i
                                                                class="icon ion-calendar tx-16 lh-0 op-6"></i></span>
                                                    </div>
                                                    <input type="text" name="mfg_date" class="form-control fc-datepicker"
                                                        value="{{ $product->mfg_date }}" placeholder="MM/DD/YYYY">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="">Expire Date</label>
                                                <div class="input-group input-group-dark">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i
                                                                class="icon ion-calendar tx-16 lh-0 op-6"></i></span>
                                                    </div>
                                                    <input type="text" name="exp_date" class="form-control fc-datepicker"
                                                        value="{{ $product->exp_date }}" placeholder="MM/DD/YYYY">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="">SKU Code</label>
                                                <input type="text" name="sku_code" class="form-control form-control-dark"
                                                    value="{{ $product->sku_code }}" placeholder="Example: BD:001">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="short_desc">Product Short Description</label>
                                        <textarea id="short_desc" name="short_desc" class="form-control form-control-dark">{!! $product->short_desc !!}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="long_desc">Product Long Description</label>
                                        <textarea id="long_desc" name="long_desc" class="form-control form-control-dark">{!! $product->long_desc !!}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="additional_info">Additional Info [Optional]</label>
                                        <textarea id="add_info" name="additional_info" class="form-control form-control-dark">{!! $product->additional_info !!}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    {{-- <div class="form-group">
                                        <label for="">Upload Product Image</label>
                                        <div class="custom-file">
                                            <input type="file" name="image" id="file" class="custom-file-input">
                                            <label class="custom-file-label custom-file-label-primary">Upload Image</label>
                                        </div>
                                    </div> --}}
                                    <div class="form-group">
                                        <label for="">Product Quantity</label>
                                        <div class="input-group input-group-dark">
                                            <input type="number" name="quantity" class="form-control form-control-dark"
                                                value="{{ $product->quantity }}" placeholder="Input Product Quantity"
                                                required>
                                            <div class="input-group-append">
                                                <span class="input-group-text">Pcs</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Regular Price</label>
                                        <div class="input-group input-group-dark">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">৳</span>
                                            </div>
                                            <input type="number" name="regular_price"
                                                class="form-control form-control-dark"
                                                value="{{ $product->regular_price }}" placeholder="Input Regular Price"
                                                required>
                                            <div class="input-group-append">
                                                <span class="input-group-text">BDT</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Offer Price</label>
                                        <div class="input-group input-group-dark">
                                            <input type="number" name="offer_price"
                                                class="form-control form-control-dark"
                                                value="{{ $product->offer_price }}" placeholder="Input Offer Price">
                                            <div class="input-group-append">
                                                <span class="input-group-text">%</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Feature Product?</label><br>
                                        <div class="form-check-inline">
                                            <label class="rdiobox rdiobox-info">
                                                <input name="is_featured" type="radio" value="1"
                                                    @if ($product->is_featured == 1) checked @endif>
                                                <span>Enable</span>
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="rdiobox rdiobox-info">
                                                <input name="is_featured" type="radio" value="0"
                                                    @if ($product->is_featured == 0) checked @endif>
                                                <span>Disable</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Select Product Type</label><br>
                                        <div class="form-check-inline">
                                            <label class="rdiobox rdiobox-info">
                                                <input name="product_type" type="radio" value="0"
                                                    @if ($product->product_type == 0) checked @endif>
                                                <span>Physial</span>
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="rdiobox rdiobox-info">
                                                <input name="product_type" type="radio" value="1"
                                                    @if ($product->product_type == 1) checked @endif>
                                                <span>Digital</span>
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="rdiobox rdiobox-info">
                                                <input name="product_type" type="radio" value="2"
                                                    @if ($product->product_type == 2) checked @endif>
                                                <span>Organic</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Product Tags</label>
                                        <input type="text" name="product_tags" class="form-control form-control-dark"
                                            value="{{ $product->product_tags }}" placeholder="Enter Tags Using, ">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Select Product Status</label>
                                        <select name="status" class="form-control form-control-dark select2"
                                            id="">
                                            <option value="" hidden>Please Select A Status</option>
                                            <option value="1" @if ($product->status == 1) selected @endif>Active
                                            </option>
                                            <option value="0" @if ($product->status == 0) selected @endif>
                                                Inactive</option>
                                            <option value="2" @if ($product->status == 2) selected @endif
                                                hidden>Soft Deleted</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Edit Thumbnail</label>
                                        <div class="ht-200 bg-black-2 d-flex align-items-center justify-content-center">
                                            <input type="file" name="image[]" id="image" class="inputfile"
                                                data-multiple-caption="{count} files selected" multiple>
                                            <label for="image" class="if-outline if-outline-info">
                                                <i class="icon ion-ios-upload-outline tx-24"></i>
                                                <span>Choose files...</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" name="updateProduct"
                                            class="btn btn-teal float-right">Update Product</button>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div><!-- card-body -->
                </div><!-- card -->
            </div>
        </div>
    </div>
@endsection
