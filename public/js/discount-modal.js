document.addEventListener("DOMContentLoaded", function() {
    const haveCodeCheckbox = document.getElementById("have-code");
    const codeContainer = document.getElementById("code-container");
    const modalForm = document.getElementById("modalForm");

    // Toggle visibility of code field based on checkbox
    haveCodeCheckbox.addEventListener("change", function() {
        if (this.checked) {
            codeContainer.style.display = "block";
        } else {
            codeContainer.style.display = "none";
            document.getElementById("code").value = ""; // Clear code field
        }
    });

    // Handle form submission
    modalForm.addEventListener("submit", function(event) {
        event.preventDefault(); // Prevent default form submission

        // Validate non-null fields
        const title = document.getElementById("discount-name").value.trim();
        const percentage = document.getElementById("percentage").value.trim();
        const code = haveCodeCheckbox.checked ? document.getElementById("code").value.trim() : "";

        if (!title || !percentage) {
            alert("Please fill in all required fields.");
            return;
        }

        // Prepare the form data for submission
        var formData = new FormData(modalForm);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Send AJAX request to submit the form
        $.ajax({
            url: modalForm.action, // The URL of your POST request
            method: 'POST',
            data: formData,
            processData: false, // Do not process the data
            contentType: false, // Do not set contentType
            success: function(response) {
                if (response.success) {
                    // Show success message
                    alert('Discount created successfully!');

                    // Reload the page to show the new records
                    window.location.reload();
                } else {
                    // Handle failure case
                    alert('Failed to create Discount. ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                // Handle errors
                var errorMessage = xhr.responseText || 'An error occurred.';
                alert('Error: ' + errorMessage);
            }
        });
    });
});
