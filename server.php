<?php 
require 'config/Swooleconf.php';
// require __DIR__ . '/model/Connpool.php';
// require __DIR__ . '/model/Usermodel.php';
// require __DIR__ . '/presenter/Userhandler.php';
// require __DIR__ . '/view/Userview.php';

\OpenSwoole\Runtime::enableCoroutine(SWOOLE_HOOK_ALL);


$server = new OpenSwoole\HTTP\Server("0.0.0.0", 9501);

$server->on("start", function($server){
    echo "OpenSwoole http server is started at http://0.0.0.0:9501\n";
});

$server->on("request", function($request, $response) use ($server){
    $launcher = Swooleconf::SwooleconfInstance();
    $launcher->CallInterface("LoggerInterface");
    // $pool = Connpool::ConnpoolInstance(5,$launcher);
    

	if ($request->server['request_uri'] == '/shutdown') {
        $response->end("Shutting down server...");
        $server->shutdown();
    }elseif ($request->server['request_uri'] == '/user-input') {
        $launcher->callController("Userhandler");
        $presenter = Userhandler::getInstance($launcher);
        // $conn = $pool->get();
        // $db = Usermodel::UserModelInstance($conn);
        
        // if ($request->server['request_method'] === 'POST') {
        //     $raw = $request->rawContent();
        //     $data = json_decode($raw,true);
        //     $db->insertCabang($data);
        //     $pool->put($conn);
        // }
    	$response->header("Content-Type", "text/plain");
        $response->end("Data has been inserted\n");    
    }else{
    	$response->header("Content-Type", "text/plain");
	    $response->end("Hello World\n");	
    }
});

$server->on('shutdown', function() {
    echo "Server is shutting down\n";
});

$server->start();