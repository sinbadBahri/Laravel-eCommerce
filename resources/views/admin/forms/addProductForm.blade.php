@extends('admin.master')

@section('content')
<br>

    <!-- Bootstrap 3 CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    <!-- Custom CSS for Floating Labels -->
    <link rel="stylesheet" href="{{ asset('css/product-add-form.css') }}">

    {{-- temp --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    

    <style>
        .animated {
            animation-duration: 0.5s;
            animation-fill-mode: both;
        }
    
        .fadeIn {
            animation-name: fadeIn;
        }
    
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
    
            to {
                opacity: 1;
            }
        }
    </style>
    

  <!-- Return Link -->
  <a href="javascript:history.back()" class="link-return">
      <span class="arrow">&larr;</span>
      <span style="font-size: 20px;">Return</span>
  </a>
<div class="container">
    <form class="row" action="#" method="POST">
        @csrf
        <div class="col-md-6 form-group">
            <input type="text" id="name" name="name" class="form-control" placeholder=" " />
            <label class="form-control-placeholder" for="name">Name</label>
        </div>

        <div class="col-md-6 form-group">
            <input type="text" id="slug" name="slug" class="form-control" placeholder=" " />
            <label class="form-control-placeholder" for="slug" >Slug</label>
        </div>

        <!-- Added Textarea -->
        <div class="col-md-12 form-group">
            <textarea id="description" name="description" class="form-control" placeholder=" "></textarea>
            <label class="form-control-placeholder" for="description">Description</label>
        </div>

        <!-- Select Options Side by Side -->
        <div class="col-md-6 form-group select-wrapper">
            <select id="funSelect1" class="form-control" name="brand">
                <option value="" disabled selected>Choose the Brand</option>
                @foreach ($brands as $brand)
                    
                <option value="{{$brand->id}}">{{$brand->title}}</option>
                @endforeach
            </select>
            <label class="form-control-placeholder" for="funSelect1">Brand</label>
        </div>
        
        <div class="col-md-6 form-group select-wrapper">
            <select id="funSelect2" class="form-control" name="product_type">
                <option value="" disabled selected>Choose the Type of Product</option>
                @foreach ($product_types as $product_type)
                    
                <option value="{{$product_type->id}}">{{$product_type->title}}</option>
                @endforeach
            </select>
            <label class="form-control-placeholder" for="funSelect2">Product Type</label>
        </div>

        <!-- Select with multiple options using Select2 -->
        <div class="col-md-12 form-group select-wrapper">
            <select id="funSelectMulti" class="form-control" name="categories[]" multiple="multiple">
                @foreach ($categories as $category)
                    @if ($category->status == true)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                    @else
                    <option value="{{$category->id}}" disabled>{{$category->name}}</option>
                    @endif
                @endforeach
            </select>
            <label class="form-control-placeholder" for="funSelectMulti"></label>
        </div>

        <!-- Submit Button -->
        <div class="col-md-12">
            <button type="submit" class="btn btn-custom">
                <span>
                    <span>A</span>
                    <span>d</span>
                    <span>d</span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span>P</span>
                    <span>r</span>
                    <span>o</span>
                    <span>d</span>
                    <span>u</span>
                    <span>c</span>
                    <span>t</span>
                </span>
            </button>
        </div>
          
    </form>

    <br>
    <br>

    <!-- Trigger Button for Modal -->
    <div class="col-md-12">
        <a class="link-custom" data-toggle="modal" data-target="#myBrandModal">Wanna add Brand?</a>
        <br>

        <a class="link-custom" data-toggle="modal" data-target="#myProductTypeModal">Wanna add Product Type?</a>
    </div>
</div>

<!-- Modal HTML For Brand -->
<div id="myBrandModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Brand</h4>
            </div>
            <div class="modal-body">
                <form id="modalForm" method="POST" action="{{ route('brand.create') }}">
                    @csrf
                    <div class="form-group">
                        <input type="text" class="form-control" id="title" name="title" placeholder="" />
                        <label for="title" class="form-control-placeholder">Title</label>
                    </div>
                    <button type="submit" class="btn btn-custom">
                        <span>
                          <span>A</span>
                          <span>d</span>
                          <span>d</span>
                          <span></span>
                          <span></span>
                          <span></span>
                          <span>B</span>
                          <span>r</span>
                          <span>a</span>
                          <span>n</span>
                          <span>d</span>
                        </span>
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

<!-- Modal HTML For Product Type-->
<div id="myProductTypeModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Add Product Type</h4>
          </div>
          <div class="modal-body">
              <form id="modalForm" method="POST" action="{{ route('product_type.create') }}">
                @csrf
                  <div class="form-group">
                      <input type="text" class="form-control" id="title" name="title" placeholder="" />
                      <label for="title" class="form-control-placeholder">Title</label>
                  </div>
                  <button type="submit" class="btn btn-custom">
                      <span>
                        <span>A</span>
                        <span>d</span>
                        <span>d</span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span>P</span>
                        <span>r</span>
                        <span>o</span>
                        <span>d</span>
                        <span>u</span>
                        <span>c</span>
                        <span>t</span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span>T</span>
                        <span>y</span>
                        <span>p</span>
                        <span>e</span>
                      </span>
                  </button>
              </form>
          </div>
      </div>

  </div>
</div>

<!-- Include jQuery -->
<script src="{{ asset('js/jquery.min.js') }}"></script>
<!-- Include the MultiSelect JS -->
<script src="{{ asset('js/admin-select.js') }}"></script>

<script>
      
    // Initialize Select2 with custom animation
    $('#funSelectMulti').select2({
        width: '100%',
        placeholder: 'Select Categories',
        allowClear: true,
        dropdownCssClass: 'animated fadeIn'  // Add fadeIn animation to dropdown
    });

    $(document).ready(function() {

        // AJAX for adding a new brand
        $('#modalForm').on('submit', function(e) {
            e.preventDefault(); // Prevent form from submitting normally
            
            // Get the form data
            var formData = $(this).serialize();

            $.ajax({
                type: 'POST',
                url: $(this).attr('action'), // Use the form's action attribute
                data: formData,
                success: function(response) {
                    // Assuming the response contains the newly added brand
                    var newBrand = response.brand;

                    // Add the new brand to the select dropdown
                    $('#funSelect1').append(new Option(newBrand.title, newBrand.id));

                    // Close the modal
                    $('#myBrandModal').modal('hide');

                    // Optionally reset the form
                    $('#modalForm')[0].reset();
                },
                error: function(xhr) {
                    console.error(xhr.responseText); // Log any errors
                }
            });
        });

        // Similar AJAX for adding a new product type
        $('#myProductTypeModal form').on('submit', function(e) {
            e.preventDefault(); // Prevent form from submitting normally
            
            // Get the form data
            var formData = $(this).serialize();

            $.ajax({
                type: 'POST',
                url: $(this).attr('action'), // Use the form's action attribute
                data: formData,
                success: function(response) {
                    // Assuming the response contains the newly added product type
                    var newProductType = response.product_type;

                    // Add the new product type to the select dropdown
                    $('#funSelect2').append(new Option(newProductType.title, newProductType.id));

                    // Close the modal
                    $('#myProductTypeModal').modal('hide');

                    // Optionally reset the form
                    $('#myProductTypeModal form')[0].reset();
                },
                error: function(xhr) {
                    console.error(xhr.responseText); // Log any errors
                }
            });
        });
        // Initialize Select2 with dynamic data loading
        $('#funSelectMulti').select2({
            width: '100%',
            placeholder: 'Select Categories',
            allowClear: true,
            ajax: {
                url: '/api/get-options',  // URL of the server endpoint to get the options
                dataType: 'json',
                processResults: function (data) {
                    return {
                        results: data.items.map(function(item) {
                            return {
                                id: item.id,
                                text: item.text
                            };
                        })
                    };
                }
            },
            dropdownCssClass: 'animated fadeIn'  // Add fadeIn animation
        });
    });
</script>


@endsection

