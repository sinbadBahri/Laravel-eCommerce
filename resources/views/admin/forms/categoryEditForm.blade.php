@extends('admin.master')

@section('content')

<br>
<div class="product-status mg-b-30">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="product-status-wrap">
                    <h4>Edit Category</h4>
                    <br>
                    <link rel="stylesheet" href="{{ asset('css/modal-for-product-list.css') }}">

                    <!-- Form for Editing Category -->
                    <div class="form-group">

                        <form id="editCategoryForm" action="{{route('category.update', $category->id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT') <!-- This is important for updating the resource -->

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $category->name }}" placeholder="Category Name">
                            </div>

                            <div class="form-group">
                                <label for="slug">Slug</label>
                                <input type="text" class="form-control" id="slug" name="slug" value="{{ $category->slug }}" placeholder="category-name">
                            </div>

                            <!-- Custom Select Dropdown for Parent Category -->
                            <div class="form-group custom-select">
                                <!-- Custom Select Display -->
                                <div class="select-selected">
                                    {{ $category->parent ? $category->parent->name : 'No Parent' }} <!-- Show current parent or 'No Parent' -->
                                </div>

                                <div class="select-items select-hide">
                                    <!-- Option to remove parent (set to null) -->
                                    <div data-value="">No Parent</div>

                                    <!-- List of all possible parent categories except the current one -->
                                    @foreach ($allCategories as $parentCategory)
                                        @if ($parentCategory->id != $category->id) <!-- Prevent selecting itself as parent -->
                                            <div data-value="{{ $parentCategory->id }}">{{ $parentCategory->name }}</div>
                                        @endif
                                    @endforeach
                                </div>

                                <!-- Hidden select element to store the actual parent value -->
                                <select class="form-control" name="parent" id="parent-category-select">
                                    <!-- 'No Parent' option, selected if no parent exists -->
                                    <option value="" {{ is_null($category->parent_id) ? 'selected' : '' }}>No Parent</option>

                                    <!-- Loop through all categories to populate the dropdown -->
                                    @foreach ($allCategories as $parentCategory)
                                        @if ($parentCategory->id != $category->id)
                                            <option value="{{ $parentCategory->id }}"
                                                    {{ $category->parent_id == $parentCategory->id ? 'selected' : '' }}>
                                                {{ $parentCategory->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <!-- Image Field: Optionally change the image -->
                            <div class="form-group">
                                <label for="image">Post Image (Optional)</label>
                                <input type="file" class="form-control" id="image" name="image">
                                @if ($category->image)
                                <p>Current Image:
                                    <img src="data:{{ $category->image->mime_type }};base64,{{ base64_encode($category->image->image) }}" class="img-fluid shadow-2-strong rounded mb-4" alt="{{ $category->image->alternative_text }}">
                                </p>
                                @endif
                            </div>

                            <!-- Switches -->
                            <div class="form-group">
                                <label class="form-check-label">Status</label>
                                <label class="switch">
                                    <input type="checkbox" id="status" name="status" {{ $category->status ? 'checked' : '' }}>
                                    <span class="slider"></span>
                                </label>
                            </div>

                            <div class="form-group">
                                <label class="form-check-label">Is Featured</label>
                                <label class="switch">
                                    <input type="checkbox" id="is_feutured" name="is_feutured" {{ $category->is_feutured ? 'checked' : '' }}>
                                    <span class="slider"></span>
                                </label>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">Update</button>
                        </form>

                    </div>

                    <div class="custom-pagination">
                        <ul class="pagination">
                            <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">Next</a></li>
                        </ul>
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

    .custom-select:hover .select-items {
        display: block;
    }
</style>

@endsection
