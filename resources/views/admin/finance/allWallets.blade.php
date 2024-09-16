@extends('admin.master')

@section('content')

<br>
<div class="product-status mg-b-30">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="product-status-wrap">
                    <h4>All Wallets</h4>
                    <br>
                    <br>
                    <link rel="stylesheet" href="{{ asset('css/modal-for-product-list.css') }}">

                    <table>
                        <tr>
                            <th>User</th>
                            <th>Balance</th>
                            <th>Is Active</th>
                            <th>Settings</th>
                        </tr>
                        @foreach ($wallets as $wallet)
                        <tr>
                            <td>{{ $wallet->user->name }}</td>
                            <td>{{ $wallet->balance }}</td>
                            <td>
                                @if ($wallet->is_active)
                                    <button class="pd-setting">Active</button>
                                @else
                                    <button class="ds-setting">Deactive</button>
                                @endif
                            </td>
                            <td><a href="{{ route('wallet.history', $wallet->id) }}">more</a></td>
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
