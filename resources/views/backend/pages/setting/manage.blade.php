@extends('backend.layout.template')

@section('title', 'All Brands')
@section('body-content')
    <div class="br-pagetitle">
        <i class="icon ion-ios-settings tx-70 lh-0"></i>
        <div>
        <h4>Web Settiings</h4>
        <p class="mg-b-0">Do bigger things with Bracket plus, the responsive bootstrap 4 admin template.</p>
        </div>
    </div><!-- d-flex -->

    <div class="br-pagebody">
        <div class="row row-sm mg-b-20">
            <div class="col-sm-12">
                <div class="card bd-0">
                    <div class="card-header tx-medium bd-0 tx-white">
                        Manage All Settings
                    </div><!-- card-header -->
                    <div class="card-body bd bd-t-0 rounded-bottom">
                        @foreach ($settings as $setting)
                            <form action="{{ route('setting.update', $setting->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Update Logo [215 X 66]</label><br>
                                            @if (!is_null($setting->logo))
                                                <img src="{{ asset('backend/img/settings/logo/'.$setting->logo) }}" class="img-fluid mx-auto d-block" style="width:75%;"><br>
                                                <div class="custom-file">
                                                    <input type="file" name="logo" id="logo" class="custom-file-input">
                                                    <label class="custom-file-label custom-file-label-primary">{{ $setting->logo }}</label>
                                                </div>
                                            @else
                                                <div class="ht-200 bg-black-2 d-flex align-items-center justify-content-center">
                                                    <input type="file" name="logo" id="logo"
                                                    class="inputfile" data-multiple-caption="{count} files selected">
                                                    <label for="logo" class="if-outline if-outline-info">
                                                        <i class="icon ion-ios-upload-outline tx-24"></i>
                                                        <span>Choose files...</span>
                                                    </label>
                                                </div>
                                            @endif
                                            
                                        </div>
                                        <div class="form-group">
                                            <label for="">Site Title</label>
                                            <input type="text" class="form-control form-control-dark" name="site_title" value="{{ $setting->site_title }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Phone No.</label>
                                            <input type="text" class="form-control form-control-dark" name="phone_no" @if (!is_null($setting->phone_no)) value="{{ $setting->phone_no }}" @else placeholder = "Please Enter Phone No." @endif/>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Address Info</label>
                                            <input type="text" class="form-control form-control-dark" name="address" @if (!is_null($setting->address))
                                            value = "{{ $setting->address }}"
                                            @else
                                                placeholder = "Please Enter Address Info."
                                            @endif>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Update Favicon [75 X 60]</label><br>
                                            @if (!is_null($setting->favicon))
                                                <img src="{{ asset('backend/img/settings/favicon/'.$setting->favicon) }}" class="img-fluid mx-auto d-block" style="width: 28.5%;"><br>
                                                <div class="custom-file">
                                                    <input type="file" name="favicon" id="favicon" class="custom-file-input">
                                                    <label class="custom-file-label custom-file-label-primary">{{ $setting->favicon }}</label>
                                                </div>
                                            @else
                                                <div class="ht-200 bg-black-2 d-flex align-items-center justify-content-center">
                                                    <input type="file" name="favicon" id="favicon"
                                                    class="inputfile" data-multiple-caption="{count} files selected">
                                                    <label for="favicon" class="if-outline if-outline-info">
                                                        <i class="icon ion-ios-upload-outline tx-24"></i>
                                                        <span>Choose files...</span>
                                                    </label>
                                                </div>
                                            @endif
                                            
                                        </div>
                                        <div class="form-group">
                                            <label for="">Email Address</label>
                                            <input type="email" class="form-control form-control-dark" name="email" @if (!is_null($setting->email))
                                            value = "{{ $setting->email }}"
                                            @else
                                                placeholder = "Please Enter Email Address"
                                            @endif>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Support Phone No.</label>
                                            <input type="text" class="form-control form-control-dark" name="support_phone" @if (!is_null($setting->support_phone))
                                            value = "{{ $setting->support_phone }}"
                                            @else
                                                placeholder = "Please Enter Suppport Phone No."
                                            @endif>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Business Hours</label>
                                            <input type="text" class="form-control form-control-dark" name="business_hours" @if (!is_null($setting->business_hours))
                                            value = "{{ $setting->business_hours }}"
                                            @else
                                                placeholder = "Please Enter Business Hours"
                                            @endif>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" name="setting" class="btn btn-teal float-right">Update Settings</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @endforeach
                        
                    </div><!-- card-body -->
                </div><!-- card -->
            </div>
        </div>
    </div>
@endsection