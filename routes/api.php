<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\JanreController;
use App\Http\Controllers\SearchController;
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

Route::resource('/author' , AuthorController::class);
Route::post('/author/upbeat' , [AuthorController::class , 'upbeat']);

Route::resource('/janre' , JanreController::class);
Route::post('/janre/upbeat' , [JanreController::class , 'upbeat']);

Route::resource('/book' , BookController::class);
Route::post('/book/upbeat' , [BookController::class , 'upbeat']);

Route::post('/search' , [SearchController::class , 'search']);

