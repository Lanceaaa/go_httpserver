<?php
use Swoole\Coroutine\Channel;
class WaitGroup
{
    private $chan;
    private $count;

    public function __construct()
    {
        $this->chan = new Channel(1);
        $this->count = 0;
    }

    public function Add($val)
    {
        $this->count += $val;
    }

    public function Done()
    {
        $this->chan->push(1);
    }

    public function Wait(){
        for($i=0;$i<$this->count;$i++){
            $this->chan->pop();
        }
    }
}