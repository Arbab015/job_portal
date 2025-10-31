<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Job Portal </title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    {{-- Favicon --}}
    <link href="img/favicon.ico" rel="icon">

    {{-- Google Web Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- Icon Font Stylesheet --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">



    {{-- Libraries Stylesheet --}}
    <link rel="stylesheet" href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}">

    {{-- Customized Bootstrap Stylesheet --}}
    <link rel="stylesheet" href="{{ asset('backend/css/bootstrap.min.css') }}">


    {{-- Template Stylesheet --}}
    <link rel="stylesheet" href="{{ asset('backend/css/style.css') }}">


    @vite(['resources/js/app.js'])

    @stack('styles')
</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        @if(!isset($hideComponent) || !$hideComponent)
        @include('backend.components.sidebar')
        @endif
        <div class="content">
            @unless(isset($hideComponent))
            @include('backend.components.navbar')
            @endunless
            @yield('content')
            {{-- Back to Top --}}
            @unless(isset($hideComponent))
            <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
            @endunless

        </div>
    </div>

    {{-- JavaScript Libraries --}}
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('lib/chart/chart.min.js') }}"></script>
    <script src="{{ asset('lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('lib/tempusdominus/js/moment.min.js') }}"></script>
    <script src="{{ asset('lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    {{-- Template Javascript --}}
    @stack('scripts')
    <script src="{{ asset('backend/js/main.js') }}"></script>

</body>

</html>