<?php
class News {
    public $newsId;
    public $newsText;
    public $newsSource;
    public $newsDate;

    public function __construct(int $newsId, string $newsText, string $newsSource, string $newsDate)
    {
        $this->newsId = $newsId;
        $this->newsText = $newsText;
        $this->newsSource = $newsSource;
        $this->newsDate = $newsDate;
    }
}