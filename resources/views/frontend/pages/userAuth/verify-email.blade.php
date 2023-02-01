@extends('frontend.layout.template')

@section('title', 'Verify Email')
@section('body-content')

    <main class="main pages">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{ route('home') }}" rel="nofollow"><i class="fi-rs-home mr-5"></i>{{ __('Home') }}</a>
                    <span></span> {{ __('Verify Email') }}
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
                                    <p class="mb-15 mt-15">{{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}</p>
                                </div>
                                @if (session('status') == 'verification-link-sent')
                                    <div class="mb-4 font-medium text-sm text-green-600">
                                        {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                                    </div>
                                @endif
                                <div class="row">
                                        <div class="col-lg-8">
                                            <form class="form-inline" method="POST" action="{{ route('verification.send') }}">
                                                @csrf
                                                <button type="submit" class="btn btn-heading btn-block hover-up" name="verifyEmail">{{ __('Resend Verification Email') }}</button>
                                            </form>
                                        </div>
                                        <div class="col-lg-4">
                                            <form class="form-inline" method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button type="submit" class="btn btn-heading btn-block hover-up" name="logout">{{ __('Log Out') }}</button>
                                            </form>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
@endsection