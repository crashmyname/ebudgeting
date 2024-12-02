<?php
use App\Controllers\AuthController;
use App\Controllers\CategoryController;
use App\Controllers\UserController;
use Support\Route;
use Support\View;
use Support\AuthMiddleware; //<-- Penambahan Middleware atau session login

// handleMiddleware();
Route::get('/login',[AuthController::class,'index']);
Route::post('/login',[AuthController::class, 'onLogin']);
Route::get('/', function(){
    return view('auth/login');
});
Route::group([AuthMiddleware::class],function(){
    Route::get('/home',function(){
        return view('home/home',[],'layout/app');
    });
    // USERS
    Route::get('/users',[UserController::class, 'index']);
    Route::get('/getusers',[UserController::class, 'getUser']);
    Route::post('/users',[UserController::class, 'create']);
    Route::post('/role-management/{id}',[UserController::class, 'role']);
    Route::put('/uuser/{id}',[UserController::class, 'update']);
    Route::delete('/user/{id}',[UserController::class, 'delete']);
    
    // CATEGORIES
    Route::get('/category',[CategoryController::class,'index']);
    Route::get('/getcategory',[CategoryController::class,'getCategory']);
    Route::post('/category',[CategoryController::class,'create']);
    Route::put('/ucategory/{id}',[CategoryController::class,'update']);
    Route::delete('/category/{id}',[CategoryController::class,'delete']);

    Route::post('/logout',[AuthController::class, 'logout']);
});