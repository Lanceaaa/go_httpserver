<?php
require 'vendor/autoload.php';
$client = \App\rpc\RpcClient::create('0.0.0.0', 8001);
//echo $client->getMe();
var_dump($client->getAges('lance'));