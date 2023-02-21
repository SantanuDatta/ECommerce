@extends('frontend.layout.template')

@section('title', 'Forgot Password')
@section('body-content')

    <main class="main pages">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{ route('home') }}" rel="nofollow"><i class="fi-rs-home mr-5"></i>{{ __('Home') }}</a>
                    <span></span> {{ __('Forgot Password') }}
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
                                    <h2 class="mb-15 mt-15">{{ __('Forgot your password?') }}</h2>
                                    <p class="mb-30">
                                        {{ __('Not to worry, we got you! Let’s get you a new password. Please enter your email address or your Username.') }}
                                    </p>
                                </div>
                                <form method="POST" action="{{ route('password.email') }}">
                                    @csrf
                                    <div class="form-group">
                                        <input type="email" name="email" value="{{ old('email') }}"
                                            placeholder="Enter Your Email For Password Reset*" />
                                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-heading btn-block hover-up"
                                            name="resetPassword">{{ __('Email Password Reset Link') }}</button>
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
