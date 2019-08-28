<?php
require("vendor/autoload.php");


function getMe(){
    return "lance".PHP_EOL;
}
function getAge($name){
    return $name."'s age is 19".PHP_EOL;
}

$server=new Swoole\Server('0.0.0.0', 8001, SWOOLE_PROCESS, SWOOLE_SOCK_TCP);

$server->on("receive",function(swoole_server $server, int $fd, int $reactor_id, string $data){

//    $result = [
//        'jsonrpc' => '2.0',
//        'result' => call_user_func('getMe'),
//        'id' => 1
//    ];
//    $server->send($fd, json_encode($result));
       $rpcReq=\App\rpc\RpcRequest::build($data);

       $result = $rpcReq->exec();

       $server->send($fd,json_encode($result));

});
$server->start();
