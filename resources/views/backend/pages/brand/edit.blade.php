@extends('backend.layout.template')

@section('title', 'Edit Brand')
@section('body-content')
    <div class="br-pagetitle">
        <i class="icon ion-ios-compose-outline tx-70 lh-0"></i>
        <div>
            <h4>Edit Brand</h4>
            <p class="mg-b-0">Do bigger things with Bracket plus, the responsive bootstrap 4 admin template.</p>
        </div>
    </div><!-- d-flex -->

    <div class="br-pagebody">
        <div class="row row-sm mg-b-20">
            <div class="col-sm-12">
                <div class="card bd-0">
                    <div class="card-header tx-medium bd-0 tx-white">
                        Edit Brand
                    </div><!-- card-header -->
                    <div class="card-body bd bd-t-0 rounded-bottom">
                        <form action="{{ route('brand.update', $brand->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Brand Name<span class="tx-danger">*</span></label>
                                        <input type="text" class="form-control form-control-dark" name="name"
                                            placeholder="Please Input Brand Name" value="{{ $brand->name }}">
                                        @error('name')
                                            <span class="tx-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="">Brand Short Description</label>
                                        <textarea id="short_desc" name="description" class="form-control form-control-dark">{{ $brand->description }}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Update Brand Image (Must Be 300X300 & 1MB)</label>
                                        <div class="custom-file">
                                            <input type="file" name="image" id="file" class="custom-file-input">
                                            <label class="custom-file-label custom-file-label-primary">
                                                Upload New Image</label>
                                        </div>
                                        @error('image')
                                            <span class="tx-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="">Select A Status</label>
                                        <select name="status" class="form-control form-control-dark" id="">
                                            <option value="" hidden>Please Select Status</option>
                                            <option value="0" @if ($brand->status == 0) selected @endif>Active
                                            </option>
                                            <option value="1" @if ($brand->status == 1) selected @endif>
                                                Inactive</option>
                                            <option value="2" @if ($brand->status == 2) selected @endif hidden>
                                                Soft Deleted
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" name="editBrand" class="btn btn-teal float-right">Edit
                                            Brand</button>
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
