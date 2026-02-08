<?php 
class Userhandler implements LoggerInterface{
	public static $instance = null;
	private $launcher;
    private $svcUtil;
    private $logger;
    private $username;
	public static function getInstance($launcher){
    	if(self::$instance==null){
    		self::$instance = new Userhandler($launcher);
    	}
    	return self::$instance;
    }

    private function __construct($launcher){
		$this->launcher = $launcher;
		$this->svcUtil = $this->launcher->CallServiceUtil();;
		$this->logger = $launcher->getLoggerObject();
		$this->username = $launcher->getDefaultSessionUsername();
	}

    public function InsertCabang(){
        $data = [
            'id' => 18,
            'cabang' => 'Some Cabang'
        ];
        return $this->svcUtil->CallAuthenticationService()->insertUser($data);
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