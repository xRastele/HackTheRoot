document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.challenge-form').forEach(function(form) {
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            const challengeId = this.getAttribute('data-challenge-id');
            const answer = this.querySelector('[name="answer"]').value;
            const feedbackElement = document.getElementById('feedback-' + challengeId);

            fetch('/submitChallenge', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ challengeId: challengeId, answer: answer }),
            })
                .then(response => response.json())
                .then(data => {
                    if (data.correct) {
                        feedbackElement.textContent = 'Correct! You earned ' + data.reward + ' pts.';
                    } else {
                        feedbackElement.textContent = 'Incorrect answer. Try again!';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    feedbackElement.textContent = 'An error occurred. Please try again.';
                });
        });
    });
});