@extends('admin.master')

@section('content')

<br>
<div class="product-status mg-b-30">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="product-status-wrap">
                    <h4>Users Infos</h4>
                    <div class="add-product">
                        <a href="/admin-panel/users/create-user">Add New User</a>
                    </div>
                    <br>
                    <br>
                    <br>
                    <br>
                    <link rel="stylesheet" href="{{ asset('css/modal-for-product-list.css') }}">

                    <table>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Email Verified At</th>
                            <th>Created At</th>
                            <th>Is Admin</th>
                            <th>Setting</th>
                        </tr>
                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->email_verified_at ?? 'Unverified' }}</td>
                            <td>{{ $user->created_at->format('Y-m-d') }}</td>
                            <td>
                                @if ($user->is_admin)
                                    <button class="pd-setting">Admin</button>
                                @else
                                    <button class="ds-setting">Not Admin</button>
                                @endif
                            </td>
                            <td>
                                <button data-toggle="tooltip" title="Edit" class="pd-setting-ed">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                </button>
                                <button data-toggle="tooltip" title="Trash" class="pd-setting-ed">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                </button>
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

@endsection
