<?php
class Modelutil {
    private $driver;

    public function __construct($driver) {
        $this->driver = $driver;
    }

    public function LoadUserModel() {
        $this->driver->getLauncher()->Model('Usermodel');
        return new Usermodel($this->driver);
    }
}