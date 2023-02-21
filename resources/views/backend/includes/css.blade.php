    <!-- Favicon -->
    @foreach ($settings as $setting)
        <link rel="shortcut icon" type="image/x-icon"
            href="{{ asset('backend/img/settings/favicon/' . $setting->favicon) }}" />
    @endforeach
    <!-- vendor css -->
    <link href="{{ asset('backend/lib/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/lib/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/lib/rickshaw/rickshaw.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/lib/select2/css/select2.min.css') }}" rel="stylesheet">

    {{-- Data Table CSS --}}
    <link rel="stylesheet" href="{{ asset('backend/lib/datatables.net-dt/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('backend/lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css') }}">

    {{-- Tags Input --}}
    <link rel="stylesheet" href="{{ asset('backend/lib/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">

    {{-- Toastr --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- Bracket CSS -->
    <link rel="stylesheet" href="{{ asset('backend/css/bracket.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/bracket.dark.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/custom.css') }}">
