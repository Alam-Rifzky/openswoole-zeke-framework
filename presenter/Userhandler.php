<?php 
class Userhandler implements LoggerInterface{
	public static $instance = null;
	private $launcher;
	private $modelUtil;
	public static function getInstance($launcher){
    	if(self::$instance==null){
    		self::$instance = new Userhandler($launcher);
    	}
    	return self::$instance;
    }

    private function __construct($launcher){
		$this->launcher = $launcher;
		$this->modelUtil = $launcher->CallModelUtil();
	}

    public function DebugMessage(string $message): void{
        $this->logger->WriteLog($this->launcher->getLogPaths()['visitorLogs'], $this->username, "Userhandler - " . $message,'DEBUG');
    }

    public function InfoMessage(string $message): void{
        $this->logger->WriteLog($this->launcher->getLogPaths()['visitorLogs'], $this->username, "Userhandler - " . $message,'INFO');
    }

    public function ErrorMessage(string $message): void{
        $this->logger->WriteLog($this->launcher->getLogPaths()['visitorLogs'], $this->username, "Userhandler - " . $message,'ERROR');
    }

    
}