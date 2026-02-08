<?php 
class Userview{
	public static $instance = null;

	private function __construct(){
		
	}

	public static function UserViewInstance(){
    	if(self::$instance==null){
    		self::$instance = new Userview($config);
    	}
    	return self::$instance;
    }

	public function renderSuccess(array $data, int $code = 200){
        $this->response->status($code);
        $this->response->end(json_encode($data));
    }

    public function renderError(string $message, int $code = 400){
        $this->response->status($code);
        $this->response->end(json_encode(['error' => $message]));
    }
}