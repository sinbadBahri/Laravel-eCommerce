
@if (! $mobile_widget == null)
@if ($mobile_widget->is_active)
<div class="container">
   <div class="row">
      <div class="col-md-12">
         <div class="two-slider">
            <h4>موبایل و تبلت</h4>
            <div class="owl-carousel owl-theme ov2">
               @foreach ($mobile_widget->products as $product)
                   
               <div class="item">
                  <figure>
                     <a href=""><img src="data:{{ $product->images[0]->mime_type }};base64,{{ base64_encode($product->images[0]->image) }}" class="d-block w-100" alt="{{ $product->images[0]->alternative_text }}"></a>
                  </figure>
                  <h5>{{$product->product->name}}</h5>
                  <span>{{$product->price}}</</span>
               </div>
               @endforeach
            </div>
         </div>
      </div>
   </div>
</div>
@endif
@endif