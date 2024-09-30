@extends('layouts.master')

@section('content')

<!---------------------------------->
<div class="container">

   @include('widgets.product_slider')
   <!---------------------------------->
   @include('widgets.special_offers')
   <!---------------------------------->
   @include('widgets.laptops')
   <!---------------------------------->
   @include('widgets.mobiles')
   <!---------------------------------->
   @include('widgets.best_sellers')
   <!---------------------------------->
   @include('widgets.categories')
   <!---------------------------------->
   @include('widgets.best_posts')

<!---------------------------------->

<script src="{{ asset('js/jquery-3.3.1.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/jquery.simple.timer.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/bootstrap.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/owl.carousel.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/js.js') }}" type="text/javascript"></script>



@endsection
