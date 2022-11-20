    <!-- Favicon -->
    @foreach ($settings as $setting)
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('backend/img/settings/favicon/' . $setting->favicon) }}" />
    @endforeach
    
    
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins/animate.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins/slider-range.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/main.css?v=5.5') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/custom.css') }}" />