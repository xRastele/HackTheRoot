document.addEventListener('DOMContentLoaded', function() {
    const usersPerPage = 4;
    let currentPage = 1;
    const users = Array.from(document.querySelectorAll('.leaderboard-rest .user-entry'));
    const totalPages = Math.ceil(users.length / usersPerPage);

    function showPage(page) {
        users.forEach((user, index) => {
            user.style.display = (Math.ceil((index + 1) / usersPerPage) === page) ? '' : 'none';
        });
        document.getElementById('currentPage').textContent = page;
        document.getElementById('prevPage').disabled = (page === 1);
        document.getElementById('nextPage').disabled = (page === totalPages);
    }

    document.getElementById('prevPage').addEventListener('click', function() {
        if (currentPage > 1) {
            showPage(--currentPage);
        }
    });

    document.getElementById('nextPage').addEventListener('click', function() {
        if (currentPage < totalPages) {
            showPage(++currentPage);
        }
    });

    showPage(currentPage);
});