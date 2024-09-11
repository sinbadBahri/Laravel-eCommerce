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
                                      <form id="modalForm">
                                        <!-- Custom Select Dropdown -->
                                        <div class="form-group custom-select">
                                            <div class="select-selected">Select Your  Product</div>
                                            <div class="select-items select-hide">
                                            <div>One</div>
                                            <div>Two</div>
                                            <div>Three</div>
                                            </div>
                                            <select class="form-control">
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                            </select>
                                        </div>

                                            
                                        <div class="form-group">
                                          <label for="price">Price</label>
                                          <input type="text" class="form-control" id="price" placeholder="$ 170">
                                        </div>
                                        <div class="form-group">
                                          <label for="sku">sku</label>
                                          <input type="text" class="form-control" id="sku" placeholder="smth like : 5df55g6f6g4f6g4f6h4f6hf4h4f5">
                                        </div>
                                        {{-- <div class="form-group">
                                          <label for="disabled">Disabled</label>
                                          <input type="text" class="form-control" id="disabled" value="I am not editable" disabled>
                                        </div> --}}
                                        <div class="form-group">
                                            <label for="stock_qty">Stock Quantity</label>
                                            <input type="text" class="form-control" id="stock_qty" placeholder="2">
                                          </div>

                                          <div class="form-group">
                                              <label for="image">Image</label>
                                              <input type="file" class="form-control" id="image" name="image">
                                          </div>
                                        
                                        <!-- Switches -->
                                        <div class="form-group">
                                          <label class="form-check-label">is active</label>
                                          <label class="switch">
                                            <input type="checkbox" id="flexSwitchCheckChecked" checked>
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
                                        <button data-toggle="tooltip" title="Edit" class="pd-setting-ed"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                        <button data-toggle="tooltip" title="Trash" class="pd-setting-ed"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
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
          $(".custom-select").click(function() {
              $(this).find(".select-items").toggleClass("select-hide");
              $(this).toggleClass("select-arrow-active");
          });

          $(".select-items div").click(function() {
              var value = $(this).text();
              $(this).closest(".custom-select").find(".select-selected").text(value);
              $(this).closest(".custom-select").find("select").val(value);
              $(this).closest(".select-items").addClass("select-hide");
          });

          $(document).click(function(e) {
              if (!$(e.target).closest(".custom-select").length) {
              $(".select-items").addClass("select-hide");
              $(".custom-select").removeClass("select-arrow-active");
              }
          });
          
        $('#modalForm').on('submit', function(event) {
          event.preventDefault(); // Prevent the default form submission
          
          var errors = [];
          var stock_qty = $('#stock_qty').val().trim();
          var price = $('#price').val().trim();
          var sku = $('#sku').val().trim();
  
          // Basic validation
          if (stock_qty === '') {
            errors.push('Item cannot be Out of Stock');
          }
          if (price === '') {
            errors.push('Price is required.');
          }
          if (sku === '') {
            errors.push('sku is required.');
          }
  
          // Display errors or success message
          if (errors.length > 0) {
            $('#errorMessages').html(errors.join('<br>'));
          } else {
            $('#errorMessages').html('');
            alert('Form submitted successfully!');
          }
        });
      });
    </script>

@endsection