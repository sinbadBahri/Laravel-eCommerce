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

                    <!-- Form for Editing Category Widget -->

                    <div class="form-group">

                        <form id="editBlogWidgetForm" action="{{route('categoryWidget.update', $categoryWidget->id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')



                            <div class="form-group">
                                <label for="price">Title</label>
                                <input type="text" class="form-control" id="title" name="title" value="{{ $categoryWidget->title }}" placeholder="a title">
                                <a href="">Do not Change the Title if is not necessarily</a>
                            </div>
                            <br>

                            <!-- Category Selection: Multi-select with pre-selected values -->
                            <div class="form-group custom-select-container">
                                <label for="categories">Select Your Category(s)</label>
                                <select id="categories" name="categories[]" class="custom-select" multiple>
                                    @foreach ($allCategories as $category)
                                        <option value="{{$category->id}}" @if(in_array($category->id, $categoryWidget->categories->pluck('id')->toArray())) selected @endif>{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Switches -->
                            <div class="form-group">
                                <label class="form-check-label">Is Active</label>
                                <label class="switch">
                                    <input type="checkbox" id="is_active" name="is_active" {{ $categoryWidget->is_active ? 'checked' : '' }}>
                                    <span class="slider"></span>
                                </label>
                            </div>

                            <div id="errorMessages" class="error-message"></div>
                            <button type="submit" class="btn btn-primary btn-block">Update Widget</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
