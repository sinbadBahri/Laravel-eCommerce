@extends('layouts.master')

@section('content')

<section style="background-color: #eee;">
    <div class="container py-5">
      <div class="card">
        <div class="card-body">
          <div class="row d-flex justify-content-center pb-5">
            <div class="col-md-7 col-xl-5 mb-4 mb-md-0">
              <div class="py-4 d-flex flex-row">
                <h5><span class="far fa-check-square pe-2"></span><b> پرداخت</b> |</h5>
                <span class="ps-2">ریواس</span>
              </div>
              <h4 class="text-success">{{$totalWithTax}} تومان</h4>
              <h4>اطلاعات شخصی</h4>
              <div class="d-flex pt-2">
                <div class="ms-auto">
                  <p class="text-primary">
                  </p>
                </div>
              </div>
              <p>
                اطلاعات خود را چک کنید. اگر حتی یک مورد نادرست درج شده و یا هدم تطابق با اطلاعات شخصی شما دارد ، حتما قبل از پرداخت با پشتیبانی هماهنگ کنید.
              </p>
              @if (JWTAuth::user()->userInformation)
              <div class="rounded d-flex bg-body-tertiary">
                    
                <div class="p-2">نام</div>
                <div class="ms-auto p-2">{{JWTAuth::user()->name}}</div>
              </div>
              <div class="rounded d-flex bg-body-tertiary">
                <div class="p-2">نام خانوادگی</div>
                <div class="ms-auto p-2">{{JWTAuth::user()->userInformation->lastName}}</div>
              </div>
              <div class="rounded d-flex bg-body-tertiary">

                <div class="p-2">شماره</div>
                <div class="ms-auto p-2">{{JWTAuth::user()->userInformation->countryId}}-{{JWTAuth::user()->userInformation->number}}+</div>
              </div>
              <div class="rounded d-flex bg-body-tertiary">

                <div class="p-2">آدرس</div>
                <div class="ms-auto p-2">{{JWTAuth::user()->userInformation->address}}</div>
              </div>
              <div class="rounded d-flex bg-body-tertiary">

                <div class="p-2">کد پستی</div>
                <div class="ms-auto p-2">{{JWTAuth::user()->userInformation->zipCode}}</div>
              </div>
              @else
              <h5>پروفایل خود را تکمیل کنید.</h5>
              @endif
              <hr />
              <div class="pt-2">
                  <h4>انتخاب روش پرداخت</h4>
                <div class="d-flex pb-2">
                  <div>
                    <p>
                      <b>موجودی کیف پول  <span class="text-success">{{JWTAuth::user()->wallet->balance}}   تومان</span></b>
                    </p>
                  </div>
                </div>
                <p>
                  کاربران گرامی جهت پرداخت میتوانند از به واسطه درگاه پرداخت آنلاین یا از طریق کیف پول اقدام نمایند.
                </p>
                <form action="/checkout" method="POST" class="pb-3">
                  @csrf
                  <div class="d-flex flex-row pb-3">
                    <div class="d-flex align-items-center pe-2">
                      <input class="form-check-input" type="radio" name="method" id="radioNoLabel1"
                        value="wallet" aria-label="..." checked />
                    </div>
                    <div class="rounded border d-flex w-100 p-3 align-items-center">
                      <p class="mb-0">
                        <i class="fab fa-cc-visa fa-lg text-primary pe-2"></i> کیف پول
                        
                      </p>
                    </div>
                  </div>
  
                  <div class="d-flex flex-row">
                    <div class="d-flex align-items-center pe-2">
                      <input class="form-check-input" type="radio" name="method" id="radioNoLabel2"
                        value="bank" aria-label="..." />
                    </div>
                    <div class="rounded border d-flex w-100 p-3 align-items-center">
                      <p class="mb-0">
                        <i class="fab fa-cc-mastercard fa-lg text-bodu pe-2"></i>درگاه بانک
                        
                      </p>
                    </div>
                  </div>
                  <br>
                  <button type="submit" data-mdb-ripple-init class="btn btn-primary btn-block btn-lg">پرداخت</button>
                  
                </form>
              </div>
            </div>
  
            <div class="col-md-5 col-xl-4 offset-xl-1">
              <div class="py-4 d-flex justify-content-end">
                <h6><a href="/basket">بازگشت به سبد خرید</a></h6>
              </div>
              <div class="rounded d-flex flex-column p-2 bg-body-tertiary">
                <div class="p-2 me-3">
                  <h4>فاکتور خرید</h4>
                </div>
                <div class="p-2 d-flex">
                  <div class="col-8">قیمت کالا(ها)</div>
                  <div class="ms-auto">{{$totalPrice}}</div>
                </div>
                <div class="p-2 d-flex">
                  <div class="col-8">میزان تخفیف اعمال شده</div>
                  <div class="ms-auto">{{$totalPrice - $finalPriceWithDiscount}} -</div>
                </div>
                <div class="p-2 d-flex">
                  <div class="col-8">ملبغ کل بعد از تخفیف</div>
                  <div class="ms-auto">{{$finalPriceWithDiscount}}</div>
                </div>
                <div class="border-top px-2 mx-2"></div>
                <div class="p-2 d-flex pt-3">
                  <div class="col-8">درصد مالیات</div>
                  <div class="ms-auto">{{$taxPercentage}} % </div>
                </div>
                <div class="p-2 d-flex">
                  <div class="col-8">
                    مبلغ مالیت اضافه شده
                  </div>
                  <div class="ms-auto">{{$totalWithTax - $finalPriceWithDiscount}} +</div>
                </div>
                <div class="border-top px-2 mx-2"></div>
                <div class="border-top px-2 mx-2"></div>
                <div class="p-2 d-flex pt-3">
                  <div class="col-8"><b>مبلغ نهایی</b></div>
                  <div class="ms-auto"><b class="text-success">{{$totalWithTax}} تومان</b></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
    
@endsection