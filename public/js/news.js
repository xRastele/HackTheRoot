document.addEventListener('DOMContentLoaded', function() {
const newsContainer = document.querySelector('.content-cybersec');

function fetchNews() {
    fetch('/fetch-news')
        .then(response => response.json())
        .then(news => {
            newsContainer.innerHTML = '';
            news.forEach(item => {
                const newsItem = document.createElement('p');
                newsItem.textContent = item.newsText;
                newsContainer.appendChild(newsItem);
            });
        })
        .catch(error => console.error('Error fetching news:', error));
}

    fetchNews();
    setInterval(fetchNews, 5000);
});