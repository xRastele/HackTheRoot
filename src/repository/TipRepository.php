<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/Tip.php';

class TipRepository extends Repository
{
    public function getRandomTip() {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM tips_of_the_day ORDER BY RANDOM() LIMIT 1;
        ');
        $stmt->execute();
        $tipData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($tipData === false) {
            return null;
        }

        return new Tip(
            $tipData['tip_id'],
            $tipData['tip_text']
        );
    }

    public function insertTip($tipText) {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO tips_of_the_day (tip_text) VALUES (:tipText);
        ');
        $stmt->bindParam(':tipText', $tipText, PDO::PARAM_STR);
        $stmt->execute();
    }
}