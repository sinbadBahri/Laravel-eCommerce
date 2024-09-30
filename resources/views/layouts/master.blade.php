<!doctype html>
<html>

      <meta charset="utf-8">
      <title>My Shop</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
      <link href="{{ asset('css/font-awesome.css') }}" rel="stylesheet" type="text/css">
      <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet" type="text/css">
      <link href="{{ asset('css/owl.carousel.css') }}" rel="stylesheet" type="text/css">
      <link href="{{ asset('css/owl.theme.default.css') }}" rel="stylesheet" type="text/css">
      <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css">
   </head>
   <body>
    <!---------------------nav-1----------------------->
    @include('layouts.navigation')
    <!---------------------nav-2----------------------->
    @include('layouts.navigation_2')

    <!---------------------page-content----------------------->
    @yield('content')
    <!---------------------footer----------------------->
    @include('layouts.footer')
    <!---------------------scripts----------------------->
    @stack('scripts')
    <!---------------------toasts----------------------->
   @include('layouts.toaster')

   </body>
