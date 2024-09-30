@extends('admin.master')

@section('content')

<br>
<div class="product-status mg-b-30">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="product-status-wrap">
                    <h4>Post Widgets</h4>
                    <br>
                    <br>
                    <link rel="stylesheet" href="{{ asset('css/modal-for-product-list.css') }}">

                    <table>
                        <tr>
                            <th>Title</th>
                            <th>Is Active</th>
                            <th>Settings</th>
                        </tr>
                        @foreach ($widgets as $commentWidget)
                        <tr>
                            <td>{{ $commentWidget->title }}</td>
                            <td>
                                @if ($commentWidget->is_active)
                                    <button class="pd-setting">Active</button>
                                @else
                                    <button class="ds-setting">Deactive</button>
                                @endif
                            </td>
                            <td><a href="{{ route('commentWidget.edit', $commentWidget->id) }}">more</a></td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
