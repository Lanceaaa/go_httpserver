<?php
require_once("vendor/autoload.php");
require_once(__DIR__ .'/app/Init.php');

/** @var  $router FastRoute\RouteCollector */
$router=NewRouter();

$router->add('GET', '/test'
    , TestCo());
$router->add("POST","/news/upload"
    , NewsUpload());
ListenAndServe($router);
$router->Use(MustToken());
{
    $router->add("GET","/news/{id:\d+}"
        , NewsDetail(), SetNewsCache());
    ListenAndServe($router);
}













