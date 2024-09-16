@extends('admin.master')

@section('content')

<br>
<div class="product-status mg-b-30">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="product-status-wrap">
                    <h4>Payments Records</h4>
                    <br>
                    <br>
                    <br>
                    <table>
                        <tr>
                            <th>Order Id</th>
                            <th>Status</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Refrence Number</th>
                            <th>Gateway</th>
                            <th>Created At</th>
                        </tr>
                        @foreach ($payments as $payment)
                        <tr>
                            <td>{{ $payment->order_id }}</td>
                            <td>
                                @if ($payment->status)
                                    <button class="pd-setting">Complete</button>
                                @else
                                    <button class="ds-setting">Incomplete</button>
                                @endif
                            </td>
                            <td>{{ $payment->amount }}</td>
                            <td>{{ $payment->method }}</td>
                            <td>{{ $payment->ref_num }}</td>
                            <td>{{ $payment->gateway ?? 'No Gateway Defined' }}</td>
                            <td>{{ $payment->created_at->format('Y-m-d') }}</td>
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

<!-- Include jQuery -->
<script src="{{ asset('js/jquery.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $('#modalForm').on('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            var errors = [];
            var categoryName = $('#category-name').val().trim();

            // Basic validation
            if (categoryName === '') {
                errors.push('Category name is required.');
            }

            // Display errors or success message
            if (errors.length > 0) {
                $('#errorMessages').html(errors.join('<br>'));
            } else {
                $('#errorMessages').html('');
                alert('Category created successfully!');
            }
        });
    });
</script>

@endsection
