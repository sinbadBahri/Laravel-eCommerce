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
                                <a href="product-edit.html">Add Product</a>
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

@endsection