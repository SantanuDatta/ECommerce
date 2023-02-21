@extends('backend.layout.template')

@section('title', 'Edit Category')
@section('body-content')
    <div class="br-pagetitle">
        <i class="icon ion-ios-compose-outline tx-70 lh-0"></i>
        <div>
            <h4>Edit Category</h4>
            <p class="mg-b-0">Do bigger things with Bracket plus, the responsive bootstrap 4 admin template.</p>
        </div>
    </div><!-- d-flex -->

    <div class="br-pagebody">
        <div class="row row-sm mg-b-20">
            <div class="col-sm-12">
                <div class="card bd-0">
                    <div class="card-header tx-medium bd-0 tx-white">
                        Edit Category
                    </div><!-- card-header -->
                    <div class="card-body bd bd-t-0 rounded-bottom">
                        <form action="{{ route('category.update', $category->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Category Name<span class="tx-danger">*</span></label>
                                        <input type="text" class="form-control form-control-dark" name="name"
                                            placeholder="Please Input Category Name" value="{{ $category->name }}">
                                        @error('name')
                                            <span class="tx-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="">Category Short Description</label>
                                        <textarea id="short_desc" name="description" class="form-control form-control-dark">{{ old('description'), $category->description }}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Upload ategory Image</label>
                                        <div class="custom-file">
                                            <input type="file" name="image" id="file" class="custom-file-input">
                                            <label class="custom-file-label custom-file-label-primary">
                                                Upload New Image</label>
                                            @error('image')
                                                <span class="tx-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Select A Parent Category [Optional]</label>
                                        <select name="is_parent" class="form-control form-control-dark" id="">
                                            @if ($category->is_parent == 0)
                                                <option value="0"
                                                    @if ($category->is_parent == 0) selected hidden @endif>
                                                    '{{ $category->name }}' Is Already A Parent Category</option>
                                            @else
                                                <option value="0">Make '{{ $category->name }}' A Parent Category
                                                </option>
                                            @endif
                                            @foreach ($parentCat as $pCat)
                                                <option value="{{ $pCat->id }}"
                                                    @if ($pCat->id == $category->is_parent) selected @endif>{{ $pCat->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Feature Category?</label><br>
                                        <div class="form-check-inline">
                                            <label class="rdiobox rdiobox-info">
                                                <input name="is_featured" type="radio" value="1"
                                                    @if ($category->is_featured == 1) checked @endif>
                                                <span>Enable</span>
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="rdiobox rdiobox-info">
                                                <input name="is_featured" type="radio" value="0"
                                                    @if ($category->is_featured == 0) checked @endif>
                                                <span>Disable</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Select A Status<span class="tx-danger">*</span></label>
                                        <select name="status" class="form-control form-control-dark" id="">
                                            <option value="" hidden>Please Select Status</option>
                                            <option value="0" @if ($category->status == 0) selected @endif>Active
                                            </option>
                                            <option value="1" @if ($category->status == 1) selected @endif>
                                                Inactive</option>
                                            <option value="2" @if ($category->status == 2) selected @endif hidden>
                                                Soft Deleted</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" name="editCategory" class="btn btn-teal float-right">Edit
                                            Category</button>
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
