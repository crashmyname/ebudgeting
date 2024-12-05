<?php
use App\Controllers\Api\TestController;
use Support\Middleware;
use Support\Request;
use Support\Api;
use Support\CSRFToken;

// Your Route Api Here...
Api::post('/login',[TestController::class,'loginApi']);
Api::group([Middleware::class], function(){
    Api::get('/',[TestController::class,'testApi']);
});