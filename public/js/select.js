document.addEventListener("DOMContentLoaded", function() {
    const selectedDiv = document.querySelector(".select-selected");
    const customItems = document.querySelectorAll(".select-items div");
    const actualSelect = document.getElementById("product-select");

    // Show selected value in the custom dropdown
    customItems.forEach(item => {
        item.addEventListener("click", function() {
            const selectedValue = this.getAttribute("data-value");
            selectedDiv.textContent = this.textContent;

            // Update the actual select element's value
            actualSelect.value = selectedValue;
        });
    });
});