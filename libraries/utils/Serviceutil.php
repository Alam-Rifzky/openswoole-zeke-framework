<?php
class Serviceutil {
    private $modelUtil;
    private $launcher;

    public function __construct($launcher) {
        $this->launcher = $launcher;
    }

    public function CallAuthenticationService(){
        $this->launcher->callService("user-service/user.service");
        return new Userservice($this->launcher);
    }

    // public function CallRabbitMQService(){
    //     $this->launcher->callService("messagebroker/Rabbitmqservice");
    //     return new Rabbitmqservice($this->launcher);
    // }
}