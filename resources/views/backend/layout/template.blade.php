<!DOCTYPE html>
<html lang="en">
    <head>
        {{-- Header --}}
        @include('backend.includes.header')
        @yield('site-title')

        {{-- Css --}}
        @include('backend.includes.css')
    </head>

    <body>
        {{-- Top Bar --}}
        @include('backend.includes.topbar')
        {{-- Left Menu Bar --}}
        @include('backend.includes.side-menubar')
        
        <div class="br-mainpanel">
            {{-- Body Content --}}
            @yield('body-content')
            
            {{-- Footer --}}
            @include('backend.includes.footer')
        </div><!-- br-mainpanel -->

        {{-- Script --}}
        @include('backend.includes.script')
    </body>
</html>