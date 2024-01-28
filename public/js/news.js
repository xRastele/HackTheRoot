document.addEventListener('DOMContentLoaded', function() {
    const newsContainer = document.getElementById('news-container');
    const notificationsContainer = document.getElementById('notifications-container');

    function isValidHttpUrl(string) {
        let url;

        try {
            url = new URL(string);
        } catch (_) {
            return false;
        }

        return url.protocol === "http:" || url.protocol === "https:";
    }

    function fetchNews() {
        fetch('/fetchNews')
            .then(response => response.json())
            .then(news => {
                newsContainer.innerHTML = '';
                news.forEach(item => {
                    const newsDiv = document.createElement('div');
                    newsDiv.className = 'news-div';

                    const newsText = document.createElement('a');
                    newsText.href = isValidHttpUrl(item.newsSource) ? item.newsSource : '#';
                    newsText.textContent = item.newsText;
                    newsText.target = '_blank';

                    const newsSource = document.createElement('div');
                    newsSource.textContent = isValidHttpUrl(item.newsSource) ? 'Source: ' + new URL(item.newsSource).hostname : 'Invalid source'; // Wyświetl tylko domenę lub komunikat o błędzie

                    const newsDate = document.createElement('div');
                    newsDate.textContent = 'Published: ' + item.newsDate.slice(0, -3);

                    newsDiv.appendChild(newsText);
                    newsDiv.appendChild(newsSource);
                    newsDiv.appendChild(newsDate);

                    newsContainer.appendChild(newsDiv);
                });
            })
            .catch(error => console.error('Error fetching news:', error));
    }

    function fetchNotifications() {
        fetch('/fetchNotifications')
            .then(response => response.json())
            .then(notifications => {
                notificationsContainer.innerHTML = '';
                notifications.forEach(item => {
                    const notificationDiv = document.createElement('div');
                    notificationDiv.className = 'notification-div';

                    const notificationText = document.createElement('a');
                    notificationText.textContent = item.notificationText;

                    const notificationDate = document.createElement('div');
                    notificationDate.textContent = 'Date: ' + item.notificationDate.slice(0, -3);

                    notificationDiv.appendChild(notificationText);
                    notificationDiv.appendChild(notificationDate);

                    notificationsContainer.appendChild(notificationDiv);
                });
            })
            .catch(error => console.error('Error fetching notifications:', error));
    }

    fetchNews();
    fetchNotifications();
    setInterval(fetchNews, 5000);
    setInterval(fetchNotifications, 5000);
});
