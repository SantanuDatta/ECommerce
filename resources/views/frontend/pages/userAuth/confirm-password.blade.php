@extends('frontend.layout.template')

@section('title', 'Confirm Password')
@section('body-content')

    <main class="main pages">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{ route('home') }}" rel="nofollow"><i class="fi-rs-home mr-5"></i>{{ __('Home') }}</a>
                    <span></span> {{ __('Confirm Passowrd') }}
                </div>
            </div>
        </div>
        <div class="page-content pt-150 pb-150">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-lg-6 col-md-12 m-auto">
                        <div class="login_wrap widget-taber-content background-white">
                            <div class="padding_eight_all bg-white">
                                <div class="heading_s1">
                                    <img class="border-radius-15"
                                        src="{{ asset('frontend/assets/imgs/page/forgot_password.svg') }}" alt="" />
                                    <h2 class="mb-15 mt-15">{{ __('Confirm Your Password?') }}</h2>
                                    <p class="mb-30">
                                        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
                                    </p>
                                </div>
                                <form method="POST" action="{{ route('password.confirm') }}">
                                    @csrf
                                    <div class="form-group">
                                        <input type="password" name="password" required autocomplete="current-password" />
                                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-heading btn-block hover-up"
                                            name="confirmPassword">{{ __('Confirm') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection
