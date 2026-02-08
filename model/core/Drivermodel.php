<?php
class Drivermdl implements LoggerInterface {
    private $launcher;
    private $username;
    private $dbhost=null;
    private $pool;

    public function __construct($launcher,$size=0){ 
        $this->launcher = $launcher;
        $this->username = $this->launcher->getDefaultSessionUsername();
        
        $this->pool = new OpenSwoole\Coroutine\Channel($size);

        for ($i = 0; $i < $size; $i++) {
            $this->pool->push($this->createPdo($launcher));
        }

    }

    public function getPool(){
         return $this->pool;
    }

    public function setPool($value){
        $this->pool = $value;
    }

    private function createPdo($config){
       return new PDO('mysql:host='.$config->getDbHost().';dbname='.$config->getDbName(),$config->getDbUsername(),$config->getDbPassword());
    }

    public function DebugMessage(string $message): void{
        $logger = $this->launcher->getLoggerObject();
        $logger->WriteLog($this->launcher->getLogPaths()['userLogs'], $this->username, "Model - " . $message,'DEBUG');
    }

    public function InfoMessage(string $message): void{
        $logger = $this->launcher->getLoggerObject();
        $logger->WriteLog($this->launcher->getLogPaths()['userLogs'], $this->username, "Model - " . $message,'INFO');
    }

    public function ErrorMessage(string $message): void{
        $logger = $this->launcher->getLoggerObject();
        $logger->WriteLog($this->launcher->getLogPaths()['userLogs'], $this->username, "Model - " . $message,'ERROR');
    }

    public function OpenConnection(){
        try {
            if ($this->dbhost==null) {
                $this->InfoMessage('Setting up database driver.');
                $this->DebugMessage('Opening database connection.');
                $this->dbhost = new PDO('mysql:host='. $this->launcher->databasehost .';dbname='. $this->launcher->database,$this->launcher->databaseusername,$this->launcher->databasepassword);
                $this->dbhost->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
            }
            return $this->dbhost;   
        } catch (PDOException $e) {
            $this->ErrorMessage($e->getMessage());
            die ('Database Connection Error..');
        }
    }

    public function getLauncher(){
        return $this->launcher;
    }


}