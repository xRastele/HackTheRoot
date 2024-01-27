<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/News.php';

class NewsRepository extends Repository
{
    public function getNews(): array
    {
        $result = [];

        $stmt = $this->database->connect()->prepare('
            SELECT * FROM news ORDER BY news_date DESC;
        ');

        $stmt->execute();
        $news = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach($news as $article) {
            $result[] = new News(
                $article['news_id'],
                $article['news_text'],
                $article['news_source'],
                $article['news_date']
            );
        }

        return $result;
    }
}