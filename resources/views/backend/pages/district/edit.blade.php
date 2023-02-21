@extends('backend.layout.template')

@section('title', 'Edit District')
@section('body-content')
    <div class="br-pagetitle">
        <i class="icon ion-ios-compose-outline tx-70 lh-0"></i>
        <div>
            <h4>Edit District</h4>
            <p class="mg-b-0">Do bigger things with Bracket plus, the responsive bootstrap 4 admin template.</p>
        </div>
    </div><!-- d-flex -->

    <div class="br-pagebody">
        <div class="row row-sm mg-b-20">
            <div class="col-sm-12">
                <div class="card bd-0">
                    <div class="card-header tx-medium bd-0 tx-white">
                        Edit District
                    </div><!-- card-header -->
                    <div class="card-body bd bd-t-0 rounded-bottom">
                        <form action="{{ route('district.update', $district->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">District Name</label>
                                        <input type="text" class="form-control form-control-dark" name="name"
                                            placeholder="Please Input District Name" value="{{ $district->name }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Select Division</label>
                                        <select name="division_id" class="form-control form-control-dark" id="">
                                            <option value="" hidden>Please Select A Division</option>
                                            @foreach ($divisions as $division)
                                                <option value="{{ $division->id }}"
                                                    @if ($division->id == $district->division_id) selected @endif>{{ $division->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Select Country</label>
                                        <select name="country_id" class="form-control form-control-dark" id="">
                                            <option value="" hidden>Please Select A Country</option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->id }}"
                                                    @if ($country->id == $district->country_id) selected @endif>{{ $country->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Select A Status</label>
                                        <select name="status" class="form-control form-control-dark" id="">
                                            <option value="" hidden>Please Select Status</option>
                                            <option value="1" @if ($division->status == 1) selected @endif>Active
                                            </option>
                                            <option value="0" @if ($division->status == 0) selected @endif>
                                                Inactive</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" name="editDistrict" class="btn btn-teal float-right">Edit
                                            District</button>
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
