<div class="row">
    <div class="col-md-12">
       @if (! $product_widget_slider == null)
       @if ($product_widget_slider->is_active)
           
       <div class="slider-box">
          <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
             <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                @for ($i = 1; $i <= count($product_widget_slider->products); $i++)
                    
                <li data-target="#carouselExampleIndicators" data-slide-to="{{$i}}"></li>
                @endfor
             </ol>
             <div class="carousel-inner">
                <div class="carousel-item active">
                   <div class="col-md-6" style="padding-top: 20px;">
                      <h4>SHOPPI</h4>
                      <span>بهترین فروشگاه اینترنتی (الکی)</span>
                      <p>حتما محصولات جدیدمون رو چک کنید -----></p>
                   </div>
                </div>
                @foreach ($product_widget_slider->products as $product)
                    
                <div class="carousel-item">
                   <div class="col-md-6" style="padding-top: 20px;">
                      <h4>{{$product->product->name}}</h4>
                      <span>{{$product->product->description}}</span>
                      <p>دوربین کانن از سری 6 با لنز همراه.قابلیت تصویر برداری اچ دی.قابلیت تنظیم در حالت شب . دارای دو عدد باتری اضافی</p>
                   </div>
                   @if (! $product->images == null)
                       
                   <div class="col-md-6">
                      <img src="data:{{ $product->images[0]->mime_type }};base64,{{ base64_encode($product->images[0]->image) }}" class="d-block w-100" alt="{{ $product->images[0]->alternative_text }}">
                   </div>
                   @endif
                </div>
                @endforeach
             </div>
          </div>
       </div>
       @endif
       @endif
       <!--slider-box-->
    </div>
 </div>
</div>