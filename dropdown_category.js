document.addEventListener('DOMContentLoaded', function() {
    const dropdownLinks = document.querySelectorAll('.dropdown-content a');
    dropdownLinks.forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            const categoryValue = this.getAttribute('data-value');
            document.getElementById('category').value = categoryValue;
            this.closest('form').submit();
        });
    });
});