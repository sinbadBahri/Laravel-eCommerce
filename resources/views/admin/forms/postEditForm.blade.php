@extends('admin.master')

@section('content')
<br>
<div class="product-status mg-b-30">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="product-status-wrap">
                    <h4>Edit Blog Post</h4>
                    <br><br>
                    <link rel="stylesheet" href="{{ asset('css/modal-for-product-list.css') }}">

                    <!-- Modal for adding categories -->
                    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" id="loginModalLabel">Add Category</h4>
                                </div>
                                <div class="modal-body">
                                    <form id="modalForm" action="{{route('genre.create')}}" method="POST" >
                                        @csrf
                                        <div class="form-group">
                                            <label for="category-name">Genre Name</label>
                                            <input type="text" class="form-control" id="genre-title" name="title" placeholder="Artificial Intelligence">
                                        </div>
                                        <div id="errorMessages" class="error-message"></div>
                                        <button type="submit" class="btn btn-primary btn-block">Create Genre</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Blog Post Form -->
                    <div class="form-group">
                        <form method="POST" action="{{ route('posts.update', $post->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="title" name="title" value="{{ $post->title }}" required>
                            </div>

                            <div class="form-group">
                                <label for="slug">Slug</label>
                                <input type="text" class="form-control" id="slug" name="slug" value="{{ $post->slug }}" placeholder="blog-post-title">
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="4" required>{{ $post->description }}</textarea>
                            </div>

                            <!-- Image Field: Optionally change the image -->
                            <div class="form-group">
                                <label for="image">Post Image (Optional)</label>
                                <input type="file" class="form-control" id="image" name="image">
                                @if ($post->images)
                                @foreach ($post->images as $image)

                                <p>Current Image:
                                    <img src="data:{{ $image->mime_type }};base64,{{ base64_encode($image->image) }}" class="img-fluid shadow-2-strong rounded mb-4" alt="{{ $image->alternative_text }}">
                                </p>
                                @endforeach
                                @endif
                            </div>

                            <!-- Genre Selection: Multi-select with pre-selected values -->
                            <div class="form-group custom-select-container">
                                <label for="genres">Select Your Genre(s)</label>
                                <select id="genres" name="genres[]" class="custom-select" multiple>
                                    @foreach ($allGenres as $genre)
                                        <option value="{{$genre->id}}" @if(in_array($genre->id, $post->genres->pluck('id')->toArray())) selected @endif>{{$genre->title}}</option>
                                    @endforeach
                                </select>

                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#loginModal">
                                    Add Blog Post Category
                                </button>
                            </div>

                            <!-- Switches for additional options -->
                            <div class="form-group">
                                <label class="form-check-label">Status</label>
                                <label class="switch">
                                    <input type="checkbox" name="publish" id="publish" {{ $post->status ? 'checked' : '' }}>
                                    <span class="slider"></span>
                                </label>
                            </div>

                            <div id="errorMessages" class="error-message"></div>
                            <button type="submit" class="btn btn-primary btn-block">Update Blog Post</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Comments Section -->
<section class="border-bottom mb-3">
    <p class="text-center"><strong>Comments</strong></p>

    @if(count($comments) > 0)

    <form id="deleteSelectedCommentsForm" action="{{ route('comments.bulkDelete', $post->id) }}" method="POST">
        @csrf
        @method('DELETE')

        <section style="background-color: #e7effd;">
            <div class="container my-5 py-5 text-body">
                <div class="row d-flex justify-content-center">
                    <div class="col-md-11 col-lg-9 col-xl-7">

                        @foreach ($comments as $comment)
                        <div class="d-flex flex-start">
                            <div class="card w-100">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <!-- Checkbox for selecting comment -->
                                        <input type="checkbox" class="comment-checkbox" name="selected_comments[]" value="{{ $comment->id }}" onchange="updateDeleteButton()">

                                        <div>
                                            <h5>{{ $comment->user->name }}</h5>
                                            <p class="small">{{ Hekmatinasser\Verta\Verta::instance($comment->created_at)->formatWord('l dS F') }}</p>
                                            <p>{{ $comment->content }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach

                        <!-- Delete selected comments button -->
                        <div class="text-center mt-3">
                            <button type="submit" id="deleteSelectedButton" class="btn btn-danger btn-lg" disabled>
                                Delete 0 comments
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </form>
    @endif
    <p class="text-center"><strong>Post Has No Comments</strong></p>
</section>









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

    function updateDeleteButton() {
        const checkboxes = document.querySelectorAll('.comment-checkbox');
        const deleteButton = document.getElementById('deleteSelectedButton');
        let selectedCount = 0;

        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                selectedCount++;
            }
        });

        // Update the button text with the number of selected comments
        deleteButton.textContent = `Delete ${selectedCount} comments`;

        // Enable or disable the button based on selection
        deleteButton.disabled = selectedCount === 0;
    }
</script>
@endsection
