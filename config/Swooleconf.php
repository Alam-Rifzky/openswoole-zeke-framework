<?php 
class Swooleconf{
	public static $instance = null;
	public $homedir;
	private $dbHost;
	private $dbPort;
	private $dbName;
	private $dbUsername;
	private $dbPassword;
	private $poolsize;
	private $username;

	public static function SwooleconfInstance(){
    	if(self::$instance==null){
    		self::$instance = new Swooleconf();
    	}
    	return self::$instance;
    }

    private function __construct() {
    	$this->homedir = '/var/www/openswoole-test/';
    	$this->dbHost = 'fac-institute.com';
    	$this->dbPort = '3306';
    	$this->dbName = 'facinsti_uat';
    	$this->dbUsername = 'facinsti_rifzky';
    	$this->dbPassword = 'bmwM3GTR@2025!!';
    	$this->poolsize = 16;
    }

	public function getLoggerObject(){
        $this->Lib('utils/Fileutil');
        return new Fileutil();
    }

    public function getDefaultSessionUsername(){
        return ($this->username==null||$this->username!='') ? $this->username : str_replace(':','_',$_SERVER['REMOTE_ADDR']);
    }

    public function setUsername($value){
    	$this->username = $value;
    }

    public function CallModelUtil(){
        $this->Lib('utils/Modelutil');
        $this->Model('core/Drivermodel');
        $coreModel = new Drivermdl($this);
        return new Modelutil($coreModel);
    }

	public function CallServiceUtil(){
        $this->Lib('utils/Serviceutil');
        return new Serviceutil($this);
    }

    public function getLogPaths(){
        return [
            'userLogs' => $this->homedir.'logs/userlogs/',
            'visitorLogs' => $this->homedir.'logs/visitorlogs/'
        ];
    }

    public function CallInterface($file){
        include_once $this->homedir.'interfaces/'.$file.'.php';
    }

    public function callController($controllername){
        require_once $this->homedir . "presenter/" . $controllername . ".php";
    }

	public function callService($serviceName){
        require_once $this->homedir . "services/" . $serviceName . ".php";
    }

    public function Lib($file){
        include_once $this->homedir.'libraries/'.$file.'.php';
    }

    public function Ent($file){
        include_once $this->homedir.'entities/beans/'.$file.'.php';
    }

    public function JustInclude($path){
        include_once $this->homedir.$path.'.php';   
    }

    public function Model($file){
        include_once $this->homedir.'model/'.$file.'.php';
    }

    public function getPoolSize(){
    	return $this->poolsize;
    }

    public function getDbHost(){
		return $this->dbHost;
	}

	public function setDbHost($dbHost){
		$this->dbHost = $dbHost;
	}

	public function getDbPort(){
		return $this->dbPort;
	}

	public function setDbPort($dbPort){
		$this->dbPort = $dbPort;
	}

	public function getDbName(){
		return $this->dbName;
	}

	public function setDbName($dbName){
		$this->dbName = $dbName;
	}

	public function getDbUsername(){
		return $this->dbUsername;
	}

	public function setDbUsername($dbUsername){
		$this->dbUsername = $dbUsername;
	}

	public function getDbPassword(){
		return $this->dbPassword;
	}

	public function setDbPassword($dbPassword){
		$this->dbPassword = $dbPassword;
	}

}