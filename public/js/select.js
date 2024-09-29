document.addEventListener("DOMContentLoaded", function() {
    // Handle Product Select Dropdown
    setupCustomSelect(".custom-select", "product-select");

    // Handle Discount Select Dropdown (if applicable)
    setupCustomSelect(".discount-select", "discount-select");

    function setupCustomSelect(selectContainerClass, selectElementId) {
        const container = document.querySelector(selectContainerClass);
        if (!container) {
            console.error(`Container with class ${selectContainerClass} not found.`);
            return; // Exit if container not found
        }

        const selectedDiv = container.querySelector(".select-selected");
        const customItems = container.querySelectorAll(".select-items div");
        const actualSelect = document.getElementById(selectElementId);

        if (!selectedDiv || !customItems.length || !actualSelect) {
            console.error('One of the necessary elements is missing');
            return; // Exit if necessary elements are missing
        }

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
