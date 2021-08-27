<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AutherController;
use App\Http\Controllers\Api\BookController;


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


Route::post("register", [AutherController::class,"register"]);

Route::post("login", [AutherController::class,"login"]);


Route::group(["middleware"=> ["auth:api"]],function () {


    Route::get("profile", [AutherController::class,"profile"]);
    Route::get("logout", [AutherController::class,"logout"]);

    Route::post("create-book", [BookController::class,"createBook"]);
    Route::get("list-books", [BookController::class,"listBook"]);
    Route::get("single-book/{id}", [BookController::class,"singleBook"]);
    Route::post("update-book/{id}", [BookController::class,"updataBook"]);
    Route::delete("delete-book/{id}", [BookController::class,"deleteBook"]);


});






