<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/News.php';
require_once __DIR__.'/../models/Notification.php';

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

    public function getNotifications(): array
    {
        $result = [];
        if(isset($_SESSION['username'])) {
            $current_username = $_SESSION['username'];
        }
        else
        {
            return $result;
        }

        $stmt = $this->database->connect()->prepare('
            SELECT notifications.* FROM notifications 
            JOIN users ON notifications.user_id = users.user_id 
            WHERE users.username = :username OR notifications.user_id = 0
            ORDER BY notifications.notification_date DESC;
            ');
        $stmt->bindParam(":username", $current_username, PDO::PARAM_STR);
        $stmt->execute();
        $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach($notifications as $notification) {
            $result[] = new Notification(
                $notification['notification_id'],
                $notification['user_id'],
                $notification['notification_date'],
                $notification['notification_text']
            );
        }

        return $result;
    }
}