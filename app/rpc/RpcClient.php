<?php
namespace App\rpc;
class  RpcClient{
    /** @var \Swoole\Client $client */
    private $client;
    public function __construct($client)
    {
        $this->client = $client;
    }
    static function create($addr,$port){
        $client = new \Swoole\Client(SWOOLE_SOCK_TCP);
        if ($client->connect($addr, $port, -1))
        {
            return new self($client);
        }
        return null;
    }
    public function __call($name, $arguments)
    {
        $request=[
            "jsonrpc"=>"2.0",
            "method"=>$name,
            "params"=>$arguments,
             "id"=>1
        ];
        $this->client->send(json_encode($request));

        $response=RpcResponse::build($this->client->recv());
        return  $response->getResult();
    }


}