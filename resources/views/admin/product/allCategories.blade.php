@extends('admin.master')

@section('content')

<br>
        <div class="product-status mg-b-30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="product-status-wrap">
                            <h4>Categories</h4>
                            {{-- <div class="add-product">
                                <a href="/admin-panel/products/add-product">Create Base Product</a>
                            </div> --}}
                            <br>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#loginModal">
                                Add Category
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
                                      <h4 class="modal-title" id="loginModalLabel">Form with Switches</h4>
                                    </div>
                                    <div class="modal-body">
                                      <form id="modalForm" action="{{route('category.create')}}" method="POST">

                                        @csrf
                                        <div class="form-group">
                                          <label for="name">name</label>
                                          <input type="text" class="form-control" id="name" name="name" placeholder="Category Name">
                                        </div>
                                        <div class="form-group">
                                          <label for="slug">slug</label>
                                          <input type="text" class="form-control" id="slug" name="slug" placeholder="category-name">
                                        </div>

                                        <!-- Custom Select Dropdown -->
                                        <div class="form-group custom-select">
                                          <!-- Custom Select Display -->
                                          <div class="select-selected">Select The Parent Category (Optional)</div>
                                          <div class="select-items select-hide">
                                            @foreach ($categories as $category)

                                            <div data-value="{{$category->id}}">{{$category->name}}</div>
                                            @endforeach
                                          </div>

                                          <!-- Actual Select Element -->
                                          <select class="form-control" name="parent" id="product-select">
                                              <option value="" selected disabled>Select The Parent Category (Optional)</option>
                                              @foreach ($categories as $category)

                                              <option value="{{$category->id}}">{{$category->name}}</option>
                                              @endforeach
                                          </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="image">Image</label>
                                            <input type="file" class="form-control" id="image" name="image">
                                        </div>

                                        <!-- Switches -->
                                        <div class="form-group">
                                          <label class="form-check-label">status</label>
                                          <label class="switch">
                                            <input type="checkbox" id="flexSwitchCheckChecked" name="status" checked>
                                            <span class="slider"></span>
                                          </label>
                                        </div>
                                        <div class="form-group">
                                          <label class="form-check-label">is feutured</label>
                                          <label class="switch">
                                            <input type="checkbox" id="flexSwitchCheckDefault" name="is_feutured" defaultchecked>
                                            <span class="slider"></span>
                                          </label>
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
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Status</th>
                                    <th>Parent Category</th>
                                    <th>Is Feutured</th>
                                    <th>Setting</th>
                                </tr>
                                @foreach ($categories as $category)

                                <tr>
                                    <td>{{$category->name}}</td>
                                    <td>{{$category->slug}}</td>
                                    <td>
                                        @if ($category->status)

                                        <button class="pd-setting">Active</button>
                                        @else
                                        <button class="ds-setting">Disabled</button>
                                        @endif
                                    </td>
                                    <td>
                                      @if ($category->parent)
                                      {{$category->parent->name}}
                                      @else
                                          --No Parent--
                                      @endif
                                    </td>
                                    <td>
                                        @if ($category->is_feutured)

                                        <button class="pd-setting">Feutured</button>
                                        @else
                                        <button class="ds-setting">Not Feutured</button>
                                        @endif
                                    </td>
                                    <td>
                                      <form action="" method="GET">
                                          @csrf
                                          <button data-toggle="tooltip" title="Edit" class="pd-setting-ed" name="category_id" value="{{$category->id}}">
                                              <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                          </button>
                                      </form>
                                      <form action="{{route('category.delete')}}" method="POST">
                                          @csrf
                                          <button data-toggle="tooltip" title="Trash" class="pd-setting-ed" name="category_id" value="{{$category->id}}">
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
    <!-- Include JS to sync custom select with actual select -->
    <script src="{{ asset('js/select.js') }}"></script>
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
                var formData = new FormData(this);

                $.ajax({
                    url: $(this).attr('action'), // The URL of your POST request
                    method: 'POST',
                    data: formData,
                    processData: false, // Do not process the data
                    contentType: false, // Do not set contentType
                    success: function(response) {
                        if (response.success) {
                            // Show success message
                            alert('Category created successfully!');

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
