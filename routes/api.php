<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/users/{id?}',[UserApiController::class,'showUser']);
Route::post('/users/add',[UserApiController::class,'add']);
Route::post('/users-multi-add',[UserApiController::class,'addmul']);
Route::put('/update-multi-add/{id}',[UserApiController::class,'update']);
Route::delete('/delete-multi/{ids}',[UserApiController::class,'delete']);


Route::delete('/delete-multi-json',[UserApiController::class,'deletemul']);


Route::post('/user-token',[UserApiController::class,'registration']);
Route::post('/user-token-login',[UserApiController::class,'login']);

