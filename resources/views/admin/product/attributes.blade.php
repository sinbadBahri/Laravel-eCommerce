@extends('admin.master')

@section('content')

<br>
        <div class="product-status mg-b-30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="product-status-wrap">
                            <h4>Attributes</h4>
                            <br>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#loginModal">
                                Add Attribute
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
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title" id="loginModalLabel">Add Attribute</h4>
                                    </div>
                                    <div class="modal-body">
                                      <form id="modalForm" action="{{route('attribute.create')}}" method="POST">
                                        @csrf

                                        <div class="form-group">
                                          <label for="title">Title</label>
                                          <input type="text" class="form-control" id="title" name="title" placeholder="color">
                                        </div>
                                        <div class="form-group">
                                          <label for="description">Description</label>
                                          <input type="text" class="form-control" id="description" name="description" placeholder="Color of the Product.">
                                        </div>

                                        <div id="errorMessages" class="error-message"></div>
                                        <button type="submit" class="btn btn-primary btn-block">Create</button>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                              </div>


                            <table>
                                <tr>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Related Product Types</th>
                                    <th>Setting</th>
                                </tr>
                                @foreach ($attributes as $item)

                                <tr>
                                    <td>{{$item->title}}</td>
                                    <td>{{substr($item->description, 0, 100)}} ...</td>
                                    <td>
                                        {{-- @foreach ($item->productTypes as $productType)
                                            {{$productType->title}},
                                        @endforeach --}}
                                    </td>
                                    <td>
                                        <form action="" method="GET">
                                            @csrf
                                            <button data-toggle="tooltip" title="Edit" class="pd-setting-ed" name="attribute_id" value="{{$item->id}}">
                                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                            </button>
                                        </form>
                                        <form action="{{route('attribute.delete')}}" method="POST">
                                            @csrf
                                            <button data-toggle="tooltip" title="Trash" class="pd-setting-ed" name="attribute_id" value="{{$item->id}}">
                                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
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
    </div>


    <!-- Include jQuery -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>

    <script>
      $(document).ready(function() {
            // Set up CSRF token for AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Handle form submission
            $('#modalForm').on('submit', function(event) {
                event.preventDefault(); // Prevent the default form submission

                // Create a FormData object to handle file uploads and form data
                var errors = [];
                var title = $('#title').val().trim();
                var description = $('#description').val().trim();
                var formData = new FormData(this);

                // Basic validation
                if (title === '') {
                    errors.push('Title is required.');
                }
                if (description === '') {
                    errors.push('Description is required.');
                }

                $.ajax({
                    url: $(this).attr('action'), // The URL of your POST request
                    method: 'POST',
                    data: formData,
                    processData: false, // Do not process the data
                    contentType: false, // Do not set contentType
                    success: function(response) {
                        if (response.success) {
                            // Show success message
                            alert(response.message);

                            // Reload the page to show the new records
                            window.location.reload();
                        } else {
                            // Handle failure case (if needed)
                            alert('Failed to create Category.');
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle errors
                        alert('An error occurred: ' + xhr.responseText);
                    }
                });
            });
      });
    </script>

@endsection
