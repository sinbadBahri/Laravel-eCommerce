@extends('admin.master')

@section('content')
<br>
<div class="product-status mg-b-30">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="product-status-wrap">
                    <h4>Create Blog Post</h4>
                    <br>
                    <br>
                    <link rel="stylesheet" href="{{ asset('css/modal-for-product-list.css') }}">

                    <!-- Modal -->
                    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" id="loginModalLabel">Add Category</h4>
                                </div>
                                <div class="modal-body">
                                    <form id="modalForm">
                                        <div class="form-group">
                                            <label for="category-name">Category Name</label>
                                            <input type="text" class="form-control" id="category-name" placeholder="Category Name">
                                        </div>
                                        <div id="errorMessages" class="error-message"></div>
                                        <button type="submit" class="btn btn-primary btn-block">Create Category</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Blog Post Form -->
                    <div class="form-group">
                        <form method="POST" action="#" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Blog Post Title" required>
                            </div>

                            <div class="form-group">
                                <label for="slug">Slug</label>
                                <input type="text" class="form-control" id="slug" name="slug" placeholder="blog-post-title">
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="description" name="description" placeholder="Post Body Text" rows="4" required></textarea>
                            </div>

                            <div class="form-group">
                                <label for="image">Post Image</label>
                                <input type="file" class="form-control" id="image" name="image">
                            </div>

                            <div class="form-group custom-select-container">
                                <label for="product">Select Your Product</label>
                                <select id="product" class="custom-select">
                                    <option value="" disabled selected>Select Your Product</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                                
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#loginModal">
                                    Add Blog Post Category
                                </button>
                            </div>

                            <!-- Switches for additional options -->
                            <div class="form-group">
                                <label class="form-check-label">Status</label>
                                <label class="switch">
                                    <input type="checkbox" name="publish" id="publish" checked>
                                    <span class="slider"></span>
                                </label>
                            </div>

                            <div id="errorMessages" class="error-message"></div>
                            <button type="submit" class="btn btn-primary btn-block">Upload Blog Post</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include jQuery -->
<script src="{{ asset('js/jquery.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $('#modalForm').on('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            var errors = [];
            var categoryName = $('#category-name').val().trim();

            // Basic validation
            if (categoryName === '') {
                errors.push('Category name is required.');
            }

            // Display errors or success message
            if (errors.length > 0) {
                $('#errorMessages').html(errors.join('<br>'));
            } else {
                $('#errorMessages').html('');
                alert('Category created successfully!');
            }
        });
    });
</script>
@endsection


