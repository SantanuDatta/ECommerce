<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    @include('frontend.includes.header')
    @yield('site-ttle')
    @include('frontend.includes.css')
</head>

<body>
    @include('frontend.includes.navbar')

    @yield('body-content')

    @include('frontend.includes.footer')
    @include('frontend.includes.script')
</body>

</html>
