@if (! $category_widget == null)
@if ($category_widget->is_active)  
<div class="container">
   <div class="row">
      <div class="col-md-12">
         <div class="three-slider">
            <h4>دسته بندی ها</h4>
            <div class="owl-carousel owl-theme ov3">
                @foreach ($category_widget->categories as $category)
                @if ($category->status == 1)
                <div class="item">
                    <figure>
                        <a href="">
                            <img src="data:{{ $category->image->mime_type }};base64,{{ base64_encode($category->image->image) }}" alt="{{ $category->image->alternative_text }}" style="background-color: #B7CADB; height: auto;
                    border-radius: 50%; margin: 0 auto; width: 100px; display: block; padding: 7px;"></a>
                    </figure>
                    <h5>{{ $category->name }}</h5>
                </div>
                        
                @endif
               @endforeach
            </div>
         </div>
      </div>
   </div>
</div>
@endif
@endif