@extends('admin.master')

@section('content')

<br>
        <div class="product-status mg-b-30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="product-status-wrap">
                            <h4>Products List</h4>
                            <div class="add-product">
                                <a href="/admin-panel/products/add-product">Create Base Product</a>
                            </div>
                            <br>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#loginModal">
                                Add Product Line
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
                                      <form id="modalForm" action="{{route('product_line.create')}}"  method="POST">
                                        @csrf
                                        <!-- Custom Select Dropdown -->
                                        <div class="form-group custom-select">
                                          <!-- Custom Select Display -->
                                          <div class="select-selected">Select Your Product</div>
                                          <div class="select-items select-hide">
                                            @foreach ($products as $product)
                                                
                                            <div data-value="{{$product->id}}">{{$product->name}}</div>
                                            @endforeach
                                          </div>
                                      
                                          <!-- Actual Select Element -->
                                          <select class="form-control" name="product" id="product-select">
                                              <option value="" selected disabled>Select a product</option>
                                              @foreach ($products as $product)
                                                  
                                              <option value="{{$product->id}}">{{$product->name}}</option>
                                              @endforeach
                                          </select>
                                        </div>

                                            
                                        <div class="form-group">
                                          <label for="price">Price</label>
                                          <input type="text" class="form-control" id="price" name="price" placeholder="$ 170">
                                        </div>
                                        <div class="form-group">
                                          <label for="sku">sku</label>
                                          <input type="text" class="form-control" id="sku" name="sku" placeholder="smth like : 5df55g6f6g4f6g4f6h4f6hf4h4f5">
                                        </div>
                                        {{-- <div class="form-group">
                                          <label for="disabled">Disabled</label>
                                          <input type="text" class="form-control" id="disabled" value="I am not editable" disabled>
                                        </div> --}}
                                        <div class="form-group">
                                            <label for="stock_qty">Stock Quantity</label>
                                            <input type="text" class="form-control" id="stock_qty" name="stock_qty" placeholder="2">
                                          </div>

                                          <div class="form-group">
                                              <label for="image">Image</label>
                                              <input type="file" class="form-control" id="image" name="image">
                                          </div>
                                        
                                        <!-- Switches -->
                                        <div class="form-group">
                                          <label class="form-check-label">is active</label>
                                          <label class="switch">
                                            <input type="checkbox" id="flexSwitchCheckChecked" name="is_available" checked>
                                            <span class="slider"></span>
                                          </label>
                                        </div>
                            
                                        <div class="form-group">
                                          <label class="form-check-label">has discount</label>
                                          <label class="switch">
                                            <input type="checkbox" id="flexSwitchCheckDisabled" disabled>
                                            <span class="slider"></span>
                                          </label>
                                        </div>
                            
                                        <div class="form-group">
                                          <label class="form-check-label">has tax</label>
                                          <label class="switch">
                                            <input type="checkbox" id="flexSwitchCheckCheckedDisabled" checked disabled>
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
                                    <th>Product Title</th>
                                    <th>sku</th>
                                    <th>Status</th>
                                    <th>Price</th>
                                    <th>Has Discount</th>
                                    <th>Stock</th>
                                    <th>Setting</th>
                                </tr>
                                <tbody id="productTableBody">
                                @foreach ($productCollection as $item)
                                    
                                <tr>
                                    <td>{{$item->product->name}}</td>
                                    <td>{{$item->sku}}</td>
                                    <td>
                                        @if ($item->is_available)
                                            
                                        <button class="pd-setting">Active</button>
                                        @else
                                        <button class="ds-setting">Disabled</button>
                                        @endif
                                    </td>
                                    <td>{{$item->price}}</td>
                                    <td>
                                        @if ($item->discount !== null)
                                        {{$item->discount->percentage}}%
                                        @else
                                        No Discount
                                        @endif
                                    </td>
                                    <td>{{$item->stock_qty}}</td>
                                    <td>
                                      <form action="{{ route('post.edit', $item->id) }}" method="GET">
                                          @csrf
                                          <button data-toggle="tooltip" title="Edit" class="pd-setting-ed" name="product_line_id" value="{{$item->id}}">
                                              <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                          </button>
                                      </form>
                                      <form action="{{route('product_line.delete')}}" method="POST">
                                          @csrf
                                          <button data-toggle="tooltip" title="Trash" class="pd-setting-ed" name="product_line_id" value="{{$item->id}}">
                                              <i class="fa fa-trash-o" aria-hidden="true"></i>
                                          </button>
                                      </form>
                                    </td>
                                </tr>
                                @endforeach
                              </tbody>
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
    <!-- Script to sync custom select with actual select -->
    <script>
      $(document).ready(function() {
        // Handle the form submission via AJAX
          $('#modalForm').on('submit', function(e) {
              e.preventDefault(); // Prevent the default form submission

              let formData = $(this).serialize(); // Serialize the form data

              $.ajax({
                  type: 'POST',
                  url: $(this).attr('action'), // Use the form's action attribute as the AJAX URL
                  data: formData,
                  success: function(response) {
                      // Assuming the server returns the newly created product line's ID and name
                      let newProductLine = response.product_line;

                      // Close the modal
                      $('#loginModal').modal('hide');

                      // Optionally, reset the form fields
                      $('#modalForm')[0].reset();

                      // Dynamically add the new product line to the table
                      let newTableRow = `
                          <tr>
                              <td>${newProductLine.name}</td>
                              <td>${newProductLine.sku}</td>
                              <td>
                                  <button class="pd-setting">Active</button>
                              </td>
                              <td>${newProductLine.price}</td>
                              <td>No Discount</td>
                              <td>${newProductLine.stock_qty}</td>
                              <td>
                                  <button data-toggle="tooltip" title="Edit" class="pd-setting-ed">
                                      <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                  </button>
                                  <button data-toggle="tooltip" title="Trash" class="pd-setting-ed">
                                      <i class="fa fa-trash-o" aria-hidden="true"></i>
                                  </button>
                              </td>
                          </tr>
                      `;
                      
                      $('#productTableBody').append(newTableRow);


                      // Show a success message (optional)
                      alert('Product Line added successfully!');
                  },
                  error: function(xhr, status, error) {
                      // Handle errors (optional)
                      console.error('Error creating product line:', error);
                      alert('Failed to add Product Line. Please try again.');
                  }
              });
          });
      });
      document.addEventListener("DOMContentLoaded", function() {
          const selectedDiv = document.querySelector(".select-selected");
          const customItems = document.querySelectorAll(".select-items div");
          const actualSelect = document.getElementById("product-select");

          // Show selected value in the custom dropdown
          customItems.forEach(item => {
              item.addEventListener("click", function() {
                  const selectedValue = this.getAttribute("data-value");
                  selectedDiv.textContent = this.textContent;

                  // Update the actual select element's value
                  actualSelect.value = selectedValue;
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