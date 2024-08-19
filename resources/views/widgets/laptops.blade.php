@if (! $laptop_widget == null)
   @if ($laptop_widget->is_active)
   <div class="container">
      <div class="row">
         <div class="col-md-12">
            <div class="one-slider">
               <h4>{{$laptop_widget->title}}</h4>
               <div class="owl-carousel owl-theme ov1">
                   @foreach ($laptop_widget->products as $product)
                       
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