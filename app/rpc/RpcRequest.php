<?php
namespace App\rpc;

const  RPC_PARSEERRO=-32700;
const  RPC_INVALIDREQUEST=-32600;
const  RPC_METHODNOTFOUND=-32601;
const RPC_INVALIDPARAMS=-32602;
const RPC_CUSTOMERERROR1=-32000;
const RPC_CUSTOMERERROR2=-32001;
const RPC_CUSTOMERERROR=-320099;

class RpcRequest{
    private $data="";
    private $method="";
    private $params=[];

    /**
     * @return string|null
     */
    public function getMethod(): ?string
    {
        return $this->method;
    }

    /**
     * @param string|null $method
     */
    public function setMethod(?string $method): void
    {
        $this->method = $method;
    }

    /**
     * @return array|null
     */
    public function getParams(): ?array
    {
        return $this->params;
    }

    /**
     * @param array|null $params
     */
    public function setParams(?array $params): void
    {
        $this->params = $params;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }
    private $id=0;

    public function __construct(string $data)
    {
        $this->data = json_decode($data,1);
        $this->method=$this->getProp("method");
        $this->params=$this->getProp("params");
        $this->id=$this->getProp("id");
    }
    private function  getProp($prop){
        if(in_array($prop,array_keys($this->data))){
            return $this->data[$prop];
        }
        return null;
    }

    public static function build($data){
        return new self($data);
    }
    private function ExecSuccess($result){
        $jsonRet=[
            "jsonrpc"=>"2.0",
             "result"=>$result,
             "id"=>$this->getId()
        ];
        return $jsonRet;
    }
    private function ExecFail($code,$message,$data=null){
        $jsonRet=[
            "jsonrpc"=>"2.0",
            "error"=>[
                "code"=>$code,
                "message"=>$message,
                "data"=>$data
            ],
            "id"=>null
        ];
        return $jsonRet;
    }
    public function exec(){
        try{
            if(function_exists($this->getMethod())){
                return $this->ExecSuccess(call_user_func($this->getMethod(),...$this->getParams()));
            }
            throw new RPCException("method not found",RPC_METHODNOTFOUND);

        }catch (RPCException $RPCException){
            return $this->ExecFail($RPCException->getCode(),$RPCException->getMessage());

        }
        catch(\Exception $exception){
            return $this->ExecFail(RPC_CUSTOMERERROR,$exception->getMessage());
        }
    }


}