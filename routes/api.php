<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/task/user/{id_user}', [TaskController::class, 'searchUser']);
    Route::get('/task/project/{id_project}', [TaskController::class, 'searchProject']);
    Route::post('logout',[AuthController::class, 'logout']);
    Route::apiResource('task', TaskController::class);
    Route::apiResource('project', ProjectController::class);
    Route::apiResource('user', UserController::class);
});

Route::post('register',[AuthController::class, 'register']);
Route::post('login',[AuthController::class, 'login']);
// Route::get('user',[UserController::class,'index']);


