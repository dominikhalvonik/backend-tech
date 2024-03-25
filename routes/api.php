<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;

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

Route::post('/test-post', [TestController::class, 'testPost']);
Route::post('/test-file', [TestController::class, 'testFile']);
Route::get('/get-user/{id}', [TestController::class, 'findUserById']);
Route::post('/save-user', [TestController::class, 'createUser']);
Route::post('/add-user-addr', [TestController::class, 'addUserAddress']);
Route::post('/get-user-by-phone', [TestController::class, 'findUserByPhone']);
Route::delete('/delete-user/{id}', [TestController::class, 'deleteUser']);
Route::patch('/update-user/{id}', [TestController::class, 'updateUser']);
