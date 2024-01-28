<?php
class Notification {
    public $notificationId;
    public $userId;
    public $notificationDate;
    public $notificationText;

    public function __construct($notificationId, $userId, $notificationDate, $notificationText)
    {
        $this->notificationId = $notificationId;
        $this->userId = $userId;
        $this->notificationDate = $notificationDate;
        $this->notificationText = $notificationText;
    }

}