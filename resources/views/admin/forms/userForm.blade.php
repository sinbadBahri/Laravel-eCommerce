@extends('admin.master')

@section('content')
<br>
<div class="product-status mg-b-30">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="product-status-wrap">
                    <h4>Create New User</h4>
                    <br>
                    <link rel="stylesheet" href="{{ asset('css/modal-for-product-list.css') }}">
                    
                    <!-- Blog Post Form -->
                    <div class="form-group">
                        <form method="POST" action="/admin-panel/users/create-user" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Hamid" required>
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="hamid@gmail.com">
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="text" class="form-control" id="password" name="password" placeholder="**********" required>
                            </div>

                            <!-- Switches for additional options -->
                            <div class="form-group">
                                <label class="form-check-label">Is Admin</label>
                                <label class="switch">
                                    <input type="checkbox" name="is_admin" id="is_admin" defaultchecked>
                                    <span class="slider"></span>
                                </label>
                            </div>

                            <div id="errorMessages" class="error-message"></div>
                            <button type="submit" class="btn btn-primary btn-block">Add User</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


