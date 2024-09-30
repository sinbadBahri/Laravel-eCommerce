$(document).ready(function() {
    $('.product-form').on('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        var form = $(this);
        var formData = form.serialize(); // Serialize form data
        var productId = form.find('input[name="productLine"]').val();

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    showToast('Success', response.message, 'success');
                    updateCartItems();
                    updateQuantity(productId);
                }
            },
            error: function(xhr) {
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    showToast('Error', xhr.responseJSON.message, 'error');
                }
            }
        });
    });

    function updateCartItems() {
        $.ajax({
            url: '/cart-items',
            type: 'GET',
            success: function(response) {
                $('#cart-items').text(response.cartItems);
            },
            error: function() {
                console.error('Failed to fetch cart items.');
            }
        });
    }

    function showToast(title, message, type) {
        var toastHeaderClass = type === 'success' ? 'bg-success' : 'bg-danger';
        var toastTitle = type === 'success' ? 'Success' : 'Error';

        var toastHTML = `
            <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 11">
                <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="5000">
                    <div class="toast-header ${toastHeaderClass}">
                       <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                        <strong class="me-auto">${toastTitle}</strong>
                    </div>
                    <div class="toast-body">
                        ${message}
                    </div>
                </div>
            </div>
        `;

        $('body').append(toastHTML);
        var toastEl = $('.toast').last()[0];
        var toast = new bootstrap.Toast(toastEl);
        toast.show();
    }

    function updateQuantity(productId) {
        // Find the quantity button by ID (make sure this ID is unique in the HTML)
        var quantityBtn = $('#quantity-' + productId);

        // Debug: Check if the button is found
        console.log('Button found:', quantityBtn.length > 0);

        // Check if the quantity button exists on the page
        if (quantityBtn.length) {
            // Get the current quantity and update it by incrementing
            var currentQuantity = parseInt(quantityBtn.text());
            console.log('Current quantity:', currentQuantity);

            // Update the text of the button with the new quantity
            quantityBtn.text(currentQuantity + 1);
            console.log('Updated quantity:', currentQuantity + 1);
        } else {
            console.log('No quantity button found for product ID: ' + productId);
        }
    }
});
