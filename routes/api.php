<?php

use App\Http\Controllers\Api\AdController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\CategoryConroller;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\User\UserController;
use Illuminate\Support\Facades\Route;


Route::post('login',[AuthController::class,'login']);

Route::middleware(['auth:api'])->group(function(){

    Route::post('register',[AuthController::class,'register'])
    ->middleware('register');

     Route::post('logout',[AuthController::class,'logout']);

     

    //Category
    Route::post('make/category',[CategoryConroller::class,'store']);
    Route::post('update/category/{id}',[CategoryConroller::class,'update']);
    Route::delete('delete/category/{id}',[CategoryConroller::class,'destroy']);
    Route::get('get/category/{id}',[CategoryConroller::class,'show']);
    Route::get('get/all/categories',[CategoryConroller::class,'index']);


    //users info

     Route::post('update/user/{id}',[UserController::class,'update']);
     Route::get('get/user/{id}',[UserController::class,'show']);
     Route::get('get/all/users',[UserController::class,'index']);
     Route::delete('delete/user/{id}',[UserController::class,'destroy']);

     //ads

     Route::post('make/ads',[AdController::class,'store']);
     Route::post('update/ads/{id}',[AdController::class,'update']);
     Route::get('get/all/ads',[AdController::class,'index']);
     Route::get('get/ads/{id}',[AdController::class,'show']);
     Route::delete('delete/ads/{id}',[AdController::class,'destroy']);
     Route::get('ads/filter', [AdController::class, 'filter']);

     //Review

     Route::post('make/review',[ReviewController::class,'store']);
     Route::post('update/review/{id}',[ReviewController::class,'update']);
     Route::get('get/all/reviews',[ReviewController::class,'index']);
     Route::get('get/review/{id}',[ReviewController::class,'show']);
     Route::delete('delete/review/{id}',[ReviewController::class,'destroy']);

    

});