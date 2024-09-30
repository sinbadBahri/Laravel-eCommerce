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
                                    <form id="modalForm" method="POST" action="{{ route('genre.create') }}">
                                        @csrf
                                        <div class="form-group">
                                            <label for="genre-name">Genre Name</label>
                                            <input type="text" class="form-control" id="genre-name" name="title" placeholder="like: Science" required>
                                        </div>
                                        <div id="errorMessages" class="error-message"></div>
                                        <button type="submit" class="btn btn-primary btn-block">Create</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Blog Post Form -->
                    <div class="form-group">
                        <form method="POST" action="" enctype="multipart/form-data">
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
                                <label for="genres">Select Your Genre(s)</label>
                                <select id="genres" name="genres[]" class="custom-select" multiple>
                                    @foreach ($allGenres as $genre)
                                    <option value="{{$genre->id}}">{{$genre->title}}</option>
                                    @endforeach
                                </select>
                                
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#loginModal">
                                    Add New Genre
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
        // Handle the form submission
        $('#modalForm').on('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            var form = $(this);
            var formData = form.serialize(); // Serialize the form data

            $.ajax({
                url: form.attr('action'), // The URL where the form will be submitted
                type: 'POST',
                data: formData,
                success: function(response) {
                    // Assuming the response contains the new category details
                    if (response.success) {
                        // Update the genres dropdown list
                        $('#genres').append(new Option(response.category.title, response.category.id));
                        
                        // Close the modal
                        $('#loginModal').modal('hide');

                        // Optionally, you can show a success message
                        alert('Genre added successfully.');
                    } else {
                        // Handle errors
                        $('#errorMessages').html(response.error);
                    }
                },
                error: function(xhr, status, error) {
                    // Handle AJAX errors
                    $('#errorMessages').html('An error occurred. Please try again.');
                }
            });
        });
    });
</script>
@endsection


