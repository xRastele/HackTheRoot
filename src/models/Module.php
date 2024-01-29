<?php

class Module {
    private $moduleId;
    private $moduleName;
    private $lessons;

    public function __construct($moduleId, $moduleName, $lessons = []) {
        $this->moduleId = $moduleId;
        $this->moduleName = $moduleName;
        $this->lessons = $lessons;
    }

    public function getModuleId() {
        return $this->moduleId;
    }

    public function getModuleName() {
        return $this->moduleName;
    }

    public function getLessons() {
        return $this->lessons;
    }

    public function addLesson($lesson) {
        $this->lessons[] = $lesson;
    }
}
