@extends('backend.layout.template')

@section('title', 'Add Slider')
@section('body-content')
    <div class="br-pagetitle">
        <i class="icon ion-ios-plus-outline tx-70 lh-0"></i>
        <div>
        <h4>Add New Slider</h4>
        <p class="mg-b-0">Do bigger things with Bracket plus, the responsive bootstrap 4 admin template.</p>
        </div>
    </div><!-- d-flex -->

    <div class="br-pagebody">
        <div class="row row-sm mg-b-20">
            <div class="col-sm-12">
                <div class="card bd-0">
                    <div class="card-header tx-medium bd-0 tx-white">
                        Add A Slider
                    </div><!-- card-header -->
                    <div class="card-body bd bd-t-0 rounded-bottom">
                        <form action="{{ route('slider.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Slider Name</label>
                                        <input type="text" class="form-control form-control-dark" name="name" placeholder="Example Slider 1">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Slider Short Desc</label>
                                        <textarea id="short_desc" name="short_desc" class="form-control form-control-dark" required></textarea>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Upload Slider Image (2376 X 807)</label>
                                        <div class="custom-file">
                                            <input type="file" name="image" id="file" class="custom-file-input" required>
                                            <label class="custom-file-label custom-file-label-primary">Upload Image</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Select A Status</label>
                                        <select name="status" class="form-control form-control-dark" id="">
                                            <option value="" hidden>Please Select Status</option>
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" name="addSlider" class="btn btn-teal float-right">Add Slider</button>
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