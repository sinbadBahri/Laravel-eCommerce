<div class="products-slider mt-4" style="background-color: #000000;">
    <div class="products-slider-box" style="">
        <div class="justify-content-center ps-title" style="width: 100%; margin: auto; padding-top: 120px;">
            <hr style="width: 60%; height:6px; margin: auto; border-width:0; color:#ff0000;">
            <div class="line" style="border: 4px solid #ff0000; width: 50%; margin: auto; border-radius:15px;"></div>
            <div class="" style="margin-top: -50px;">
                <h2 class="section-titles text-center pt-4"
                    style="color:#ff0000; background-color: #000000; border: 2px solid #000000; width: 20%; margin: auto; font-size: 32px;">
                    categories
                </h2>
            </div>
        </div>

        <!-- products menu title for mob -->
        <div class="ps-title-mob section-titles pb-2" style="margin: auto;">
            <h4 class="section-titles text-center pt-4"
                style="color:#ff0000; background-color: #de8585;  margin: auto; font-size: 32px;">
                categories</h4>
        </div>



        <div class="container"
            style="margin-top: 40px; background-color: #e75c5c; padding-top: 15px; border-radius: 15px;">
            <!-- Swiper -->
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    @if (! $category_widget == null)
                    @if ($category_widget->is_active)
                        @foreach ($category_widget->categories as $category)
                        @if ($category->status == 1)
                            
                        <div class="swiper-slide">
                            <div class="row">
                                <div class="col-12">
                                    <img src="data:{{ $category->image->mime_type }};base64,{{ base64_encode($category->image->image) }}" alt="{{ $category->image->alternative_text }}" style="background-color: #B7CADB; height: auto;
                            border-radius: 50%; margin: 0 auto; width: 100px; display: block; padding: 7px;">
                                    <div class="" style="margin-top: 10px;">
                                        <p>{{ $category->name }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        @endif
                        @endforeach
                    @endif
                    @endif
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-pagination"></div>
            </div>

        </div>

    </div>



</div>

