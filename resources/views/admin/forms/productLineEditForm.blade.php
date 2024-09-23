@extends('admin.master')

@section('content')

<br>
<div class="product-status mg-b-30">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="product-status-wrap">
                    <h4>Edit Product Line</h4>
                    <div class="add-product">
                        <a href="/admin-panel/products">Back to Products List</a>
                    </div>
                    <br>
                    <br>
                    <link rel="stylesheet" href="{{ asset('css/modal-for-product-list.css') }}">

                    <!-- Form for Editing Product Line -->

                    <div class="form-group">

                        <form id="editProductLineForm" action="{{route('product_line.update', $productLine->id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Custom Select Dropdown -->
                            <div class="form-group custom-select product-select">

                                <!-- Custom Select Display -->
                                <div class="select-selected">
                                    {{ $productLine->product->name }} <!-- Show current base Product -->
                                </div>

                                <div class="select-items select-hide">
                                    @foreach ($products as $product)
                                    @if ($product->id != $productLine->product_id)
                                        <div data-value="{{ $product->id }}">{{ $product->name }}</div>
                                    @endif
                                    @endforeach
                                </div>

                                <!-- Actual Select Element -->
                                <select class="form-control" name="product" id="product-select">
                                    <!-- 'No Parent' option, selected if no parent exists -->
                                    <option value="{{$productLine->product_id}}" >{{ $productLine->product->name }}</option>

                                    <!-- Loop through all products to populate the dropdown -->
                                    @foreach ($products as $product)
                                        @if ($product->id != $productLine->product_id)
                                            <option value="{{ $product->id }}" {{ $productLine->product_id == $product->id ? 'selected' : '' }}>
                                                {{ $product->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="price">Price</label>
                                <input type="text" class="form-control" id="price" name="price" value="{{ $productLine->price }}" placeholder="$ 170">
                            </div>
                            <div class="form-group">
                                <label for="sku">SKU</label>
                                <input type="text" class="form-control" id="sku" name="sku" value="{{ $productLine->sku }}" placeholder="smth like: 5df55g6f6g4f6g4f6h4f6hf4h4f5">
                            </div>
                            <div class="form-group">
                                <label for="stock_qty">Stock Quantity</label>
                                <input type="text" class="form-control" id="stock_qty" name="stock_qty" value="{{ $productLine->stock_qty }}" placeholder="2">
                            </div>

                            <!-- Image Field: Optionally change the image -->
                            <div class="form-group">
                                <label for="image">Product Line Image (Optional)</label>
                                <input type="file" class="form-control" id="image" name="image">
                                @if ($productLine->images)
                                @foreach ($productLine->images as $image)

                                <p>Current Image:
                                    <img src="data:{{ $image->mime_type }};base64,{{ base64_encode($image->image) }}" class="img-thumbnail" style="width: 150px; height: 150px;" alt="{{ $image->alternative_text }}">
                                </p>
                                @endforeach
                                @endif
                            </div>

                            <!-- Custom Select Dropdown for Discounts -->
                            <div class="form-group custom-select discount-select">
                                <!-- Custom Select Display -->
                                <div class="select-selected">
                                    {{ $productLine->discount_id ? $productLine->discount->title : 'No Discount' }} <!-- Show current Discount or 'No Discount' -->
                                </div>

                                <div class="select-items select-hide">
                                    <!-- Option to remove Discount (set to null) -->
                                    <div data-value="">No Discount</div>

                                    <!-- List of all possible Discounts except the current one -->
                                    @foreach ($discounts as $discount)
                                        @if ($discount->id != $productLine->discount_id) <!-- Prevent selecting the current Discount-->
                                            <div data-value="{{ $discount->id }}">{{ $discount->title }}</div>
                                        @endif
                                    @endforeach
                                </div>

                                <!-- Hidden select element to store the actual Discount value -->
                                <select class="form-control" name="discount" id="discount-select">
                                    <!-- 'No Discount' option, selected if rather to have no Discount -->
                                    <option value="" {{ is_null($productLine->discount_id) ? 'selected' : '' }}>No Discount</option>

                                    <!-- Loop through all Discounts to populate the dropdown -->
                                    @foreach ($discounts as $discount)
                                        @if ($discount->id != $productLine->discount_id)
                                            <option value="{{ $discount->id }}"
                                                    {{ $productLine->discount_id == $discount->id ? 'selected' : '' }}>
                                                {{ $discount->title }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <!-- Switches -->
                            <div class="form-group">
                                <label class="form-check-label">Is Active</label>
                                <label class="switch">
                                    <input type="checkbox" id="is_active" name="is_available" {{ $productLine->is_available ? 'checked' : '' }}>
                                    <span class="slider"></span>
                                </label>
                            </div>

                            <div class="form-group">
                                <label class="form-check-label">Has Tax</label>
                                <label class="switch">
                                    <input type="checkbox" id="has_tax" {{ $productLine->tax_id ? 'checked' : '' }} disabled>
                                    <span class="slider"></span>
                                </label>
                            </div>

                            <div id="errorMessages" class="error-message"></div>
                            <button type="submit" class="btn btn-primary btn-block">Update Product Line</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include jQuery -->
<script src="{{ asset('js/jquery.min.js') }}"></script>
<!-- Include JS to sync custom select with actual select -->
<script src="{{ asset('js/select.js') }}"></script>

<style>
    /* Your custom select styles */
    .select-selected {
        padding: 10px;
        background-color: #f1f1f1;
        cursor: pointer;
    }

    .select-items {
        display: none;
        position: absolute;
        background-color: #f1f1f1;
        z-index: 1;
        width: 100%;
    }

    .select-items div {
        padding: 10px;
        cursor: pointer;
    }

    .select-items div:hover {
        background-color: #ddd;
    }

    /* Add custom styles */
    .custom-select:hover .select-items {
        display: block;
    }
</style>

@endsection
