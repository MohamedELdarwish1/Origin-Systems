<?php

use App\Http\Controllers\HotelsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/hotels', [HotelsController::class, 'index']);
