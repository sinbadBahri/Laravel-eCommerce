@extends('admin.master')

@section('content')
<br>

    <!-- Bootstrap 3 CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    <!-- Custom CSS for Floating Labels -->
    <link rel="stylesheet" href="{{ asset('css/product-add-form.css') }}">
    

  <!-- Return Link -->
  <a href="javascript:history.back()" class="link-return">
      <span class="arrow">&larr;</span>
      <span style="font-size: 20px;">Return</span>
  </a>
<div class="container">
    <form class="row">
        <div class="col-md-6 form-group">
            <input type="text" id="name" class="form-control" placeholder=" " />
            <label class="form-control-placeholder" for="name">Name</label>
        </div>

        <div class="col-md-6 form-group">
            <input type="text" id="slug" class="form-control" placeholder=" " />
            <label class="form-control-placeholder" for="slug">Slug</label>
        </div>

        <!-- Added Textarea -->
        <div class="col-md-12 form-group">
            <textarea id="description" class="form-control" placeholder=" "></textarea>
            <label class="form-control-placeholder" for="description">Description</label>
        </div>

        <!-- Select Options Side by Side -->
        <div class="col-md-6 form-group select-wrapper">
            <select id="funSelect1" class="form-control">
                <option value="" disabled selected>Choose an option </option>
                <option value="1">Option 1</option>
                <option value="2">Option 2</option>
                <option value="3">Option 3</option>
            </select>
            <label class="form-control-placeholder" for="funSelect1">Brand</label>
        </div>
        
        <div class="col-md-6 form-group select-wrapper">
            <select id="funSelect2" class="form-control">
                <option value="" disabled selected>Choose an option</option>
                <option value="A">Option A</option>
                <option value="B">Option B</option>
                <option value="C">Option C</option>
            </select>
            <label class="form-control-placeholder" for="funSelect2">Product Type</label>
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
                <form>
                    <div class="form-group">
                        <input type="text" class="form-control" id="title" placeholder="" />
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
              <form>
                  <div class="form-group">
                      <input type="text" class="form-control" id="title" placeholder="" />
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


@endsection
