<!DOCTYPE html>
<html class="no-js" lang="en">
    <head>    
        @include('frontend.includes.header')
        @include('frontend.includes.css')
        @yield('site-ttle')
    </head>

    <body>
        @include('frontend.includes.navbar')
    
        @yield('body-content')
        
        @include('frontend.includes.footer')
        @include('frontend.includes.script')
        @yield('pageSccrpt')
    </body>

</html>