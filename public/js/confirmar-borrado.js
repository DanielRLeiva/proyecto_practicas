document.addEventListener('DOMContentLoaded', function () {
    const selectAllCheckbox = document.getElementById('select-all');
    const checkboxes = document.querySelectorAll('input[name="selected_ids[]"]');

    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function () {
            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });
        });
    }
});
