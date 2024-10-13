<?php

use App\Http\Controllers\api\v1\EventController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::group(['prefix' => '/', 'namespace' => 'api\v1'], function($route) {

    $route->group(['prefix' => 'event'], function($route){
        $route->post('store', [EventController::class,'store']);
    });
});
