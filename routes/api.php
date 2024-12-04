<?php
use App\Controllers\AuthController;
use App\Controllers\CategoryController;
use Support\Middleware;
use Support\Request;
use Support\Api;
use Support\CSRFToken;

// Your Route Api Here...
Api::post('/login',[AuthController::class,'loginApi']);
Api::group([Middleware::class], function(){
    Api::get('/',[CategoryController::class,'testApi']);
});