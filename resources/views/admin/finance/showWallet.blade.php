@extends('admin.master')

@section('content')

<br>
<div class="product-status mg-b-30">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="product-status-wrap">
                    <h4>Wallet Details</h4>
                    <br>
                    <br>
                    <link rel="stylesheet" href="{{ asset('css/modal-for-product-list.css') }}">

                    <div class="wallet-details">
                        <h5>User: {{ $wallet->user->name }}</h5>
                        <h5>Balance: ${{ $wallet->balance }}</h5>
                        <div class="form-group">
                            <label class="form-check-label">Status</label>
                            <label class="switch">
                                <input type="checkbox" id="walletStatus" {{ $wallet->is_active ? 'checked' : '' }}>
                                <span class="slider"></span>
                            </label>
                        </div>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#updateHistoryModal">Add Wallet History</button>
                    </div>

                    <br>
                    <br>

                    <!-- Wallet History Table -->
                    <h4>Wallet History</h4>
                    <table>
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody id="walletHistoryTable">
                            @foreach ($wallet->histories as $history)
                            <tr>
                                <td>{{ $history->created_at->format('Y-m-d H:i:s') }}</td>
                                <td>
                                    @if ($history->amount > 0)
                                    + ${{ $history->amount }}
                                    @elseif ($history->amount < 0)
                                    - ${{ abs($history->amount) }}
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Modal for Updating Wallet and Adding History -->
                    <div class="modal fade" id="updateHistoryModal" tabindex="-1" role="dialog" aria-labelledby="updateHistoryModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" id="updateHistoryModalLabel">Add Wallet History</h4>
                                </div>
                                <div class="modal-body">
                                    <form id="historyForm" method="POST" action="{{ route('wallet.add.history', $wallet->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <div class="form-group">
                                            <label for="amount">Amount</label>
                                            <input type="number" class="form-control" id="amount" name="amount" placeholder="Amount" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-block">Add History</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    

                    <!-- Custom Pagination if needed -->
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

<!-- Include jQuery -->
<script src="{{ asset('js/jquery.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $('#historyForm').on('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            var form = $(this);
            var url = form.attr('action');
            var method = form.attr('method');
            var formData = form.serialize();

            $.ajax({
                url: url,
                type: method,
                data: formData,
                success: function(response) {
                    // Reload the page
                    location.reload();
                },
                error: function(xhr) {
                    // Handle any errors
                    alert('An error occurred while processing the request.');
                }
            });
        });

        // Handle the toggle switch change
        $('#walletStatus').on('change', function() {
            var isChecked = $(this).is(':checked');
            var url = '{{ route('wallet.toggle.status', $wallet->id) }}'; // URL to handle status toggle

            $.ajax({
                url: url,
                type: 'PATCH',
                data: {
                    _token: '{{ csrf_token() }}',
                    is_active: isChecked ? 1 : 0
                },
                success: function(response) {

                },
                error: function(xhr) {
                    alert('An error occurred while updating the status.');
                    // Revert the switch state if error occurs
                    $('#walletStatus').prop('checked', !isChecked);
                }
            });
        });

        
    });
</script>
