<?php
namespace App\rpc;
class RpcResponse{
    private $response;
    private $result;

    public function getResult()
    {
        return $this->result;
    }
    public function setResult($result): void
    {
        $this->result = $result;
    }

    public function __construct($response)
    {
        $this->response = $response;//{"jsonrpc":"2.0","result":3,"id":1}
        $this->parse();
    }
    private function parse(){

        $obj=json_decode($this->response,1);
        if(in_array("result",array_keys($obj))){
            $this->result=$obj["result"];
        }
        else{
            $this->result=$obj["error"];
        }

    }
    static function build($response){
        return new self($response);
    }

}