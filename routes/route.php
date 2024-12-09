<?php
use App\Controllers\ActivityController;
use App\Controllers\AuthController;
use App\Controllers\CategoryController;
use App\Controllers\ExpensesController;
use App\Controllers\FiscalController;
use App\Controllers\ItemController;
use App\Controllers\TypemodelController;
use App\Controllers\UnitController;
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
    Route::get('/user/profile/{id}',[UserController::class, 'profile']);
    Route::post('/user/profile/{id}',[UserController::class, 'updateProfile']);

    Route::get('/kirim-email',[AuthController::class, 'sendEmail']);
    Route::get('/testing',[ActivityController::class, 'activity']);
    Route::get('/tester',[CategoryController::class, 'testProtected']);
    
    // CATEGORIES
    Route::get('/category',[CategoryController::class,'index']);
    Route::get('/getcategory',[CategoryController::class,'getCategory']);
    Route::post('/category',[CategoryController::class,'create']);
    Route::get('/print-category', function(){
        return view('category/printcategory');
    });
    Route::get('/export-category-pdf',[CategoryController::class, 'exportPDF']);
    Route::post('/import-category',[CategoryController::class, 'importExcel']);
    Route::get('/export-category',[CategoryController::class, 'exportExcel']);
    Route::put('/ucategory/{id}',[CategoryController::class,'update']);
    Route::delete('/category/{id}',[CategoryController::class,'delete']);

    // ITEM
    Route::get('/item',[ItemController::class, 'index']);
    Route::get('/getitem',[ItemController::class, 'getItem']);
    Route::post('/item',[ItemController::class, 'create']);
    Route::post('/import-item',[ItemController::class, 'importExcel']);
    Route::put('/uitem/{id}',[ItemController::class, 'update']);
    Route::delete('/item/{id}',[ItemController::class, 'delete']);

    // Fiscal
    Route::get('/fiscal',[FiscalController::class, 'index']);
    Route::get('/getfiscal',[FiscalController::class, 'getFiscal']);

    // Type/Model
    Route::get('/typemodel',[TypemodelController::class, 'index']);
    Route::get('/gettypemodel',[TypemodelController::class, 'getTypeModel']);

    // Unit
    Route::get('/unit',[UnitController::class, 'index']);
    Route::get('/getunit',[UnitController::class, 'getUnit']);
    Route::post('/unit',[UnitController::class, 'create']);

    // Expenses
    Route::get('/planexpenses',[ExpensesController::class, 'indexPlan']);
    Route::get('/forecastexpenses',[ExpensesController::class, 'indexForecast']);
    Route::get('/actualexpenses',[ExpensesController::class, 'indexActual']);

    // LOGOUT
    Route::post('/logout',[AuthController::class, 'logout']);
});