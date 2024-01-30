<?php
class Tip {
    private $tipId;
    private $tipText;

    public function __construct($tipId, $tipText)
    {
        $this->tipId = $tipId;
        $this->tipText = $tipText;
    }

    public function getTipId()
    {
        return $this->tipId;
    }

    public function setTipId($tipId): void
    {
        $this->tipId = $tipId;
    }

    public function getTipText()
    {
        return $this->tipText;
    }

    public function setTipText($tipText): void
    {
        $this->tipText = $tipText;
    }


}