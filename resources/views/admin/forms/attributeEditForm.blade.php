@extends('admin.master')

@section('content')

<br>
<div class="product-status mg-b-30">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="product-status-wrap">
                    <h4>Edit Attribute</h4>
                    <br>
                    <link rel="stylesheet" href="{{ asset('css/modal-for-product-list.css') }}">

                    <!-- Modal for adding Product Type -->
                    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" id="loginModalLabel">Add Product Type</h4>
                                </div>
                                <div class="modal-body">
                                    <form id="modalForm" action="{{route('product_type.create')}}" method="POST" >
                                        @csrf
                                        <div class="form-group">
                                            <label for="productType-name">Product Type Name</label>
                                            <input type="text" class="form-control" id="productType-title" name="title" placeholder="Artificial Intelligence">
                                        </div>
                                        <div id="errorMessages" class="error-message"></div>
                                        <button type="submit" class="btn btn-primary btn-block">Create Product Type</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form for Editing Attribute -->
                    <div class="form-group">

                        <form id="editAttributeForm" action="{{route('attribute.update', $attribute->id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT') <!-- This is important for updating the resource -->

                            <div class="form-group">
                                <label for="name">Title</label>
                                <input type="text" class="form-control" id="name" name="title" value="{{ $attribute->title }}" placeholder="Attribute Title">
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="4" required>{{ $attribute->description }}</textarea>
                            </div>

                            <!-- ProductType Selection: Multi-select with pre-selected values -->
                            <div class="form-group custom-select-container">
                                <label for="productTypes">Select Your Product Type(s)</label>
                                <select id="productTypes" name="productTypes[]" class="custom-select" multiple>
                                    @foreach ($allProductTypes as $productType)
                                        <option value="{{$productType->id}}" @if(in_array($productType->id, $attribute->product_types->pluck('id')->toArray())) selected @endif>{{$productType->title}}</option>
                                    @endforeach
                                </select>

                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#loginModal">
                                    Add ProductType
                                </button>
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
                        $('#productTypes').append(new Option(response.productType.title, response.productType.id));

                        // Close the modal
                        $('#loginModal').modal('hide');

                        // Optionally, you can show a success message
                        alert(response.message);
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
