document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('tipForm');
    const messageDiv = document.getElementById('message');

    form.addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(form);

        fetch('/insertTip', {
            method: 'POST',
            body: formData
        })
            .then(response => response.text())
            .then(data => {
                messageDiv.textContent = data;
                form.reset();
            })
            .catch(error => {
                console.error('Error:', error);
                messageDiv.textContent = 'An error occurred. Please try again.';
            });
    });
});
