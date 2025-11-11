<!DOCTYPE html>
<html lang="en">

<head>
  <title>Job Portal</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css')  }}">
  <link rel="stylesheet" href="{{ asset('frontend/css/templatemo.css') }}">

  <!-- Load fonts style after rendering the layout styles -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Arima:wght@100..700&family=Baloo+2:wght@400..800&family=Baloo+Chettan+2:wght@400..800&family=DM+Serif+Text:ital@0;1&family=Merienda:wght@300..900&family=Mozilla+Headline:wght@200..700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('frontend/css/fontawesome.min.css') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />

  <link rel="stylesheet" href="{{ asset('frontend/css/custom.css') }}">
  @stack('style')
</head>

<body>

  @include('frontend.components.navbar')
  @yield('content')
  {{-- job apply model --}}
  @include('frontend.components.job_apply_modal')
  @include('frontend.components.footer')


  <!-- Start Script -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <script src="{{ asset('frontend/js/jquery-migrate-1.2.1.min.js') }}"></script>
  <script src="{{ asset('frontend/js/custom.js') }}"></script>
  <script src="{{ asset('frontend/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('frontend/js/templatemo.js') }}"></script>
  @stack('scripts')

  <!-- End Script -->
</body>

</html>