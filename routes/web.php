<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EmployeeController;

Route::get('/', function () {
    return view('welcome');
});

 Route::get('index',[EmployeeController::class,'index']);
 Route::get('index/{id}',[EmployeeController::class,'show']);
 Route::get('create',[EmployeeController::class,'create']);