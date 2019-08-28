<?php

use App\http\MyContext;

function NewsDetail(){ //获取新闻详细
    return function (MyContext $context){
        return ['news_id' => $context->getPathVars()['id'], 'news_title' => 'news title yo'];
    };
}

function SetNewsCache(){ //插入缓存
    return function (MyContext $context){
        return "set cache by NewsID".$context->getPathVars()["id"];
    };
}

function NewsUpload() {
    return function (MyContext $context) {
        $request=$context->getRequest();
        if ($request->files) {
            $filename = basename($request->files['myfile']['name']);//取文件名
            $tmpname = $request->files['myfile']['tmp_name'];
            if (move_uploaded_file($tmpname, AppRoot . "/public/" . $filename)) {
                return ["status" => "success"];
            }
        }
        return ['status' =>"error"];
    };
}
