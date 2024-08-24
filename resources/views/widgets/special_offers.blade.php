<div class="container">
    <div class="row">
       <div class="col-md-3">
          <div class="coopen">
             <img src="{{ asset('img/coopen.png') }}" class="w-100" />
          </div>
       </div>
       <div class="col-md-9">
          @if (! $special_offer_widget == null)
          @if ($special_offer_widget->is_active)
          @foreach ($special_offer_widget->products as $product)
              
          <div class="vizheh">
             <div class="col-md-6">
                <div class="vizheh-img">
                   <img src="data:{{ $product->images[0]->mime_type }};base64,{{ base64_encode($product->images[0]->image) }}" class="d-block w-100" alt="{{ $product->images[0]->alternative_text }}">
                </div>
             </div>
             <div class="col-md-6">
                <div class="vizheh-content">
                   <div><del>{{$product->price}}</del></div>
                   <h4>685,000 تومان</h4>
                   <h3>{{$product->product->name}}</h3>
                   <ul>
                      {{-- <li>حافظه داخلی 32 گیگابایت</li> --}}
                      <li>تعداد موجود در انبار  : {{$product->stock_qty}}</li>
                   </ul>
                   <hr>
                   <span>زمان باقیمانده تا پایان سفارش</span> 
                   <div class="counter" data-minutes-left="1000"></div>
                </div>
             </div>
             <div class="vizheh-tag">
                <span>فرصت ویژه</span>
             </div>
          </div>
          @endforeach
          @endif
          @endif
       </div>
    </div>
 </div>