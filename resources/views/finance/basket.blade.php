
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
<link href="{{ asset('css/bskt.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('css/media.css') }}" rel="stylesheet" type="text/css">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
{{-- <link href="{{ asset('css/order.css') }}" rel="stylesheet" type="text/css"> --}}


@extends('layouts.master')
@section('content')






<section class="buycart container">
        
        
    <div class="row">
        <div class="col-sm-5 col-md-4 col-lg-3 col-xl-2 mt-5">
            <div class="yourbuycart">
                <div><i class="bi bi-cart-fill p-3 align-items-center" style="font-size: 18px;"></i>سبد خرید شما</div>
            </div>
        </div>

    </div>

    <div class="row product-detail">

    <div class="col-md-12 col-xxl-8 product-list shadow">
        @if (!$productCollection == null)

        @foreach ($productCollection as $product)
            
        <div class="row d-flex align-items-center">
            <div class="col-12 col-md-3 p-4 text-center">
                <img src="data:{{ $product->images[0]->mime_type }};base64,{{ base64_encode($product->images[0]->image) }}" class="d-block w-100" alt="{{ $product->images[0]->alternative_text }} width="200" style="border-radius: 15px;"">
            
            </div>
            <div class="col-md-9 col-xl-3 col-xxl-3 text-center p-4">
                <h4>{{$product->title}}</h4>
                <p style="color: #6A6A6A; font-size: 14px; padding-top: 10px;">قیمت محصول:</p>
                <span
                style="text-decoration: line-through; font-size: 13px; text-decoration-color: #c412f5;">145,000
                تومان</span>
                <p style="font-size: 18px ;">{{$product->price}} تومان</p>
            </div>
            <div class="col-sm-12 col-md-8 col-xl-3 col-xxl-3 text-center text-md-start text-xl-center">
                
                <div class="btn-group">
                    <form action="/basket/add" method="POST">
                        @csrf
                        <button name="productLine" value="{{$product->id}}" type="submit" class="add-btn"><i class="bi bi-plus"></i></button>
                    </form>
                    <button class="numb-btn">{{$product->quantity}}</button>
                    <form action="/basket/remove-product" method="POST">
                    @csrf
                    <button name="productLineId" value="{{$product->id}}" type="submit" class="trash-btn"><i class="bi bi-trash"></i></button>
                    </form>
                    <button class="count-btn">تعداد</button>
                </div>
                
                
            </div>
            <div class="col-sm-12 col-md-4 col-lg-3 col-xl-3 col-xxl-3 mt-3 text-center text-xl-center">
                <p>قیمت : {{$product->price * $product->quantity}} تومان</p>
            </div>
        </div>
        @endforeach
            
        @else

        <h3>سبد خرید شما خالی است.</h3>
            
        @endif
    </div>



    <div class="bill col-md-12 col-xxl-3 offset-1 shadow mt-3 mt-xxl-0" style="background-color:rgb(248,248,248); border-radius: 15px; padding: 15px;">
        <div class="row d-flex text-center pt-5">
            <div class="col-md-6">
                مبلغ کل
            </div>
            <div class="col-md-6">
                {{$totalPrice}} تومان
            </div>
        </div>

        <div class="row d-flex text-center pt-3">
            <div class="col-md-6 text-primary">
                تخفیف
            </div>
            <div class="col-md-6 text-primary" style="font-family: myvazir;">
                777 تومان
            </div>
        </div>

        <div class="row d-flex text-center pt-3 pb-3" style="border-bottom: 2px solid #eee;">
            <div class="col-md-6">
                هزینه ارسال
            </div>
            <div class="col-md-6">
                وابسته به آدرس
            </div>
        </div>

        <div class="text-center mt-3">
            <div>
                مبلغ قابل پرداخت:
            </div>
            <div class="pt-3">
                <h5 class="text-warning">
                    777 <span style="font-size: 16px;">تومان</span>
                </h5>
            </div>
        </div>

        <div class="text-center mt-3">
            <div class="btn-group">
                <a href="/checkout">
                    <button class="arrow-btn"><i class="bi bi-arrow-left"></i></button>

                    <button class="submit-btn">ادامه ثبت سفارش</button>
                </a>

            </div>
        </div>

        <div class="text-center mt-3">
            <div>
                <p style="color: #9E9E9E; font-size: 14px; text-align: right;">
                    کالاهای موجود در سبد شما ثبت و رزرو نشده‌اند، برای ثبت سفارش مراحل بعدی را تکمیل کنید. <i
                        class="bi bi-info-circle"></i>
                </p>
            </div>
        </div>




    </div>

</section>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3"
crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"
integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD"
crossorigin="anonymous"></script>



@endsection
