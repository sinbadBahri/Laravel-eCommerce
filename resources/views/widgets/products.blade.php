<div class="col-11 mx-auto">
        
    <div class="mt-5 p-4 warm-drinks justify-content-center">
        <div class="warm-drinks-header">
            <div class="row col-11 mx-auto">
                <div class="d-flex align-items-center col-sm-12 col-md-6 warm-drinks-title">
                    <p>Products</p>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row cards" style="width:fit-content; overflow: hidden;">
                
                
                
                @if (! $best_seller_widget == null)
        
                @if($best_seller_widget->is_active)
                <div class="photo-slider">
                    @foreach($best_seller_widget->products as $product)
                    
                    
                    <div class="col-lg-6 col-xl-4 mt-4">
                        <div class="card shadow">
                            @foreach($product->images as $image)
                            <a href="/tmp-product/{{ $product->id }}"><img class="card-img-top" src="data:{{ $image->mime_type }};base64,{{ base64_encode($image->image) }}"
                                alt="Card image cap">
                                <div class="overlay">
                                    <div class="text" style=" padding: 10px; width: 65%; text-align: center;">
                                        {{ $image->alternative_text }}
                                    </div>
                                </div></a>
                                @endforeach
                                
                                <div class="percent-off" style="margin:auto; width: 30%;">
                                    <p class="text-center"
                                    style="background-color: #F9595F; border-radius: 5px; margin-top: -12px; color: #fff; font-size: 13px;">
                                    10% discount</p>
                                </div>
                                <div class="card-body">
                                    <div class="row d-flex align-items-center" style="position: relative;">
                                        <div class="col-md-9 product-title">
                                            <h4>{{ $product->product->name }}<span><i class="bi bi-star-fill star"
                                                style="padding-right: 5px;"></i><i
                                                class="bi bi-star-fill star"></i><i
                                                class="bi bi-star-fill star"></i><i
                                                class="bi bi-star-fill star"></i><i
                                                class="bi bi-star-fill star"></i></span>
                                            </h4>
                                        </div>
                                        <div class="col-md-3 text-center heart-icon">
                                            <i class="bi bi-heart-fill"></i>
                                        </div>
                                    </div>
                                    <div class="row d-flex align-items-center">
                                        <div class="col-md-9 mt-2 pt-2">
                                            <span
                                            style="text-decoration: line-through; font-size: 13px; text-decoration-color: red;">{{ $product->price }}
                                            تومان</span>
                                            <p style="font-size: 18px; padding-top: 4px;">{{ $product->price }} تومان</p>
                                            
                                        </div>
                                        <div class="col-md-3 pt-1 text-center add-to-cart-btn">
                                            <form action="/update_item" method="post">
                                                @csrf
                                                
                                                <button class="btn btn-brown overflow-hidden update-cart" data-action="add" name="product_id" value="{{ $product->id }}">
                                                    <i class="bi bi-plus"></i>
                                                    <span
                                                    style="font-size: 14px; animation-timing-function: ease-in-out;">افزودن
                                                    به سبد خرید</span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    
                                    
                                    
                                    
                                </div>
                            </div>
                        </div>
                    
                    @endforeach
                </div>
                @endif
                @endif
                    
                    
                </div>
            </div>
            
        </div>
</div>