<?php

use App\Http\Controllers\Ads\AdsController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Categories\CategoryConroller;
use App\Http\Controllers\Review\ReviewController;
use App\Http\Controllers\User\UserController;
use Illuminate\Http\Request;
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

     Route::post('make/ads',[AdsController::class,'store']);
     Route::post('update/ads/{id}',[AdsController::class,'update']);
     Route::get('get/all/ads',[AdsController::class,'index']);
     Route::get('get/ads/{id}',[AdsController::class,'show']);
     Route::delete('delete/ads/{id}',[AdsController::class,'destroy']);
     Route::get('ads/filter', [AdsController::class, 'filter']);

     //Review

     Route::post('make/review',[ReviewController::class,'store']);
     Route::post('update/review/{id}',[ReviewController::class,'update']);
     Route::get('get/all/reviews',[ReviewController::class,'index']);
     Route::get('get/review/{id}',[ReviewController::class,'show']);
     Route::delete('delete/review/{id}',[ReviewController::class,'destroy']);

    

});