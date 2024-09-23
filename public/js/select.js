document.addEventListener("DOMContentLoaded", function() {
    // Handle Product Select Dropdown
    setupCustomSelect(".product-select", "product-select");

    // Handle Discount Select Dropdown
    setupCustomSelect(".discount-select", "discount-select");

    // Generic function to handle custom select dropdowns
    function setupCustomSelect(selectContainerClass, selectElementId) {
        const container = document.querySelector(selectContainerClass);
        const selectedDiv = container.querySelector(".select-selected");
        const customItems = container.querySelectorAll(".select-items div");
        const actualSelect = document.getElementById(selectElementId);

        // Show selected value in the custom dropdown
        customItems.forEach(item => {
            item.addEventListener("click", function() {
                const selectedValue = this.getAttribute("data-value");
                selectedDiv.textContent = this.textContent;

                // Update the actual select element's value
                actualSelect.value = selectedValue;
            });
        });
    }
});
