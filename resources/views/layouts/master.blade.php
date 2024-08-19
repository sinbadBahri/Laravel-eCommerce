<!doctype html>
<html>
   <head>
      <meta charset="utf-8">
      <title>My Shop</title>
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
   </body>