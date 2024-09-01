<!--------------Toast Logic------------------->
@if(session('success') || session('error'))
    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="5000">
            <div class="toast-header">
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                <strong class="me-auto">
                    @if(session('success'))
                        Success
                    @elseif(session('error'))
                        Error
                    @endif
                </strong>
            </div>
            <div class="toast-body">
                {{ session('success') ?? session('error') }}
            </div>
        </div>
    </div>
@endif

<!-- Bootstrap and custom scripts -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var toastElList = [].slice.call(document.querySelectorAll('.toast'));
        var toastList = toastElList.map(function (toastEl) {
            return new bootstrap.Toast(toastEl);
        });
        toastList.forEach(toast => toast.show());
    });
</script>