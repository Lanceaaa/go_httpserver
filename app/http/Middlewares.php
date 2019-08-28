<?php
function MustToken() {
    return function (\App\http\MyContext $context) {
        if($context->getRequest()->get['token']) {
            $context->next();
        } else {
            $context->abort('missing token!');
        }
    };
}