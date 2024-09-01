@if (! $best_seller_widget == null)
@if ($best_seller_widget->is_active)  
<div class="container">
   <div class="row">
      <div class="col-md-12">
         <div class="three-slider">
            <h4>محصولات پر فروش</h4>
            <div class="owl-carousel owl-theme ov3">
               @foreach ($best_seller_widget->products as $product)
               <div class="item">
                  <figure>
                     <a href=""><img src="data:{{ $product->images[0]->mime_type }};base64,{{ base64_encode($product->images[0]->image) }}" class="d-block w-100" alt="{{ $product->images[0]->alternative_text }}"></a>
                  </figure>
                  <h5>{{$product->product->name}}</h5>
                  <span>
                     {{$product->price}}  
                  </span>
                  <br>
                  <form id="product-form-{{ $product->id }}" class="product-form" action="/basket/add" method="POST">
                     @csrf
                     <input type="hidden" name="productLine" value="{{ $product->id }}">
                     <button type="submit" class="btn btn-secondary btn-sm" data-product-id="{{ $product->id }}">اضافه به سبدخرید</button>
                  </form>
               </div>
               @endforeach
            </div>
         </div>
      </div>
   </div>
</div>
@endif
@endif


<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/toaster.js') }}"></script>
