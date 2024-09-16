function showToast(message, type) {
    var toastClass = type === 'success' ? 'toast-success' : 'toast-error';
    var toastHtml = `
        <div class="toast ${toastClass} alert alert-dismissible">
            <div class="toast-header">
                <strong class="mr-auto">${type === 'success' ? 'Success' : 'Error'}</strong>
                <button type="button" class="close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body">${message}</div>
        </div>
    `;

    // Append the toast to the container
    $('#toaster-container').append(toastHtml);

    // Show the toast and hide it after 3 seconds
    $('.toast').last().addClass('show');
    setTimeout(function() {
        $('.toast').first().removeClass('show').fadeOut(300, function() {
            $(this).remove();
        });
    }, 3000);
}