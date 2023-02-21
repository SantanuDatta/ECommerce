@extends('backend.layout.template')

@section('title', 'Edit Country')
@section('body-content')
    <div class="br-pagetitle">
        <i class="icon ion-ios-compose-outline tx-70 lh-0"></i>
        <div>
            <h4>Edit Country</h4>
            <p class="mg-b-0">Do bigger things with Bracket plus, the responsive bootstrap 4 admin template.</p>
        </div>
    </div><!-- d-flex -->

    <div class="br-pagebody">
        <div class="row row-sm mg-b-20">
            <div class="col-sm-12">
                <div class="card bd-0">
                    <div class="card-header tx-medium bd-0 tx-white">
                        Edit Country
                    </div><!-- card-header -->
                    <div class="card-body bd bd-t-0 rounded-bottom">
                        <form action="{{ route('country.update', $country->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="">Country Name</label>
                                        <input type="text" class="form-control form-control-dark" name="name"
                                            placeholder="Please Input Country Name" value="{{ $country->name }}">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="">Select Priority No.</label>
                                        <input type="number" class="form-control form-control-dark" name="priority"
                                            value="{{ $country->priority }}" required>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="">Select A Status</label>
                                        <select name="status" class="form-control form-control-dark" id="">
                                            <option value="" hidden>Please Select Status</option>
                                            <option value="1" @if ($country->status == 1) selected @endif>Active
                                            </option>
                                            <option value="0" @if ($country->status == 0) selected @endif>
                                                Inactive</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" name="editCountry" class="btn btn-teal float-right">Edit
                                            Country</button>
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
