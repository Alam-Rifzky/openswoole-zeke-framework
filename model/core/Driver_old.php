<?php 
class Driver{
	public static $instance = null;
	private $pool;

	public static function ConnpoolInstance($size,Swooleconf $config){
    	if(self::$instance==null){
    		self::$instance = new Connpool($size,$config);
    	}
    	return self::$instance;
    }


    private function __construct($size,Swooleconf $config){


        $this->pool = new OpenSwoole\Coroutine\Channel($size);

        for ($i = 0; $i < $size; $i++) {
            $this->pool->push($this->createPdo($config));
        }

    	// $this->pool = new PDOPool(
        //     (new PDOConfig())
        //         ->withHost($config->getFacdbhost())
        //         ->withPort($config->getFacdbport())
        //         ->withDbName($config->getFacdbname())
        //         ->withUsername($config->getFacdbusername())
        //         ->withPassword($config->getFacdbpassword())
        //         ->withCharset($config['charset'])
        //         ->withOptions([
        //             PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        //             PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        //         ]),
        //     $config->getPoolSize()
        // );
    }

    private function createPdo($config){
       return new PDO('mysql:host='.$config->getDbHost().';dbname='.$config->getDbName(),$config->getDbUsername(),$config->getDbPassword());
    }

    public function get(): PDO {
        return $this->pool->pop();
    }

    public function put(PDO $pdo): void {
        $this->pool->push($pdo);
    }


    public function getConnection(){
        return $this->pool->get();
    }

    public function releaseConnection($connection){
        $this->pool->put($connection);
    }
}