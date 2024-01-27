document.addEventListener('DOMContentLoaded', function() {
    const newsContainer = document.getElementById('news-container');

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
        fetch('/fetch-news')
            .then(response => response.json())
            .then(news => {
                newsContainer.innerHTML = ''; // Wyczyść aktualne newsy
                news.forEach(item => {
                    const newsDiv = document.createElement('div');
                    newsDiv.className = 'news-div';

                    const newsText = document.createElement('a');
                    newsText.href = isValidHttpUrl(item.newsSource) ? item.newsSource : '#';
                    newsText.textContent = item.newsText;
                    newsText.target = '_blank'; // Otwórz link w nowej karcie

                    const newsSource = document.createElement('div');
                    newsSource.textContent = isValidHttpUrl(item.newsSource) ? 'Source: ' + new URL(item.newsSource).hostname : 'Invalid source'; // Wyświetl tylko domenę lub komunikat o błędzie

                    const newsDate = document.createElement('div');
                    newsDate.textContent = 'Published: ' + item.newsDate;

                    newsDiv.appendChild(newsText);
                    newsDiv.appendChild(newsSource);
                    newsDiv.appendChild(newsDate);

                    newsContainer.appendChild(newsDiv);
                });
            })
            .catch(error => console.error('Error fetching news:', error));
    }


    fetchNews();
    setInterval(fetchNews, 30000); // Odświeżaj co 30 sekund
});
