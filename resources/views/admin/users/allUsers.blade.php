@extends('admin.master')

@section('content')

<br>
<div class="product-status mg-b-30">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="product-status-wrap">
                    <h4>Blog Posts List</h4>
                    <div class="add-product">
                        <a href="/admin-panel/users/create-user">Add New User</a>
                    </div>
                    <br>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#loginModal">
                        Add Blog Post Category
                    </button>
                    <br>
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

                    <table>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Email Verified At</th>
                            <th>Created At</th>
                            <th>Is Admin</th>
                            <th>Setting</th>
                        </tr>
                        {{-- @foreach ($blogPosts as $post)
                        <tr>
                            <td>{{ $post->title }}</td>
                            <td>{{ $post->category->name ?? 'Uncategorized' }}</td>
                            <td>
                                @if ($post->is_published)
                                    <button class="pd-setting">Published</button>
                                @else
                                    <button class="ds-setting">Draft</button>
                                @endif
                            </td>
                            <td>{{ $post->created_at->format('Y-m-d') }}</td>
                            <td>
                                <button data-toggle="tooltip" title="Edit" class="pd-setting-ed">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                </button>
                                <button data-toggle="tooltip" title="Trash" class="pd-setting-ed">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach --}}
                    </table>

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
