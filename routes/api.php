<?php

use App\Http\Controllers\ConvertController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::group(['prefix'=>'map-data'], function(){
    Route::get('/trong-tre', [ConvertController::class, 'getDataTT'] )->name('index');
    Route::get('/vuon-uom', [ConvertController::class, 'getDataVU'] )->name('index');    
    Route::post('/convert-data', [ConvertController::class, 'convertData'] )->name('index');    
});