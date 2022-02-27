<?php

use Davidkiarie\NextLayerJwtPackage\Http\Controllers\JwtUserController;
use Illuminate\Support\Facades\Route;

// Route::get("refresh",function(){
// return "refresh";
// });
Route::post("/refreshToken",[JwtUserController::class,'refreshToken'])->middleware('refreshJwt');
Route::post("/login",[JwtUserController::class,'login']);
