<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
	return $request->user();
});

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::group(['middleware' => 'api'], function () {
	Route::post('logout', [AuthController::class, 'logout']);
	Route::post('refresh', [AuthController::class, 'refresh']);
	Route::post('me', [AuthController::class, 'me']);
	Route::get('posts', [PostController::class, 'UserPosts']);
	Route::post('posts', [PostController::class, 'update']);
	Route::post('post', [PostController::class, 'store']);
	Route::delete('posts/{id}', [PostController::class, 'destroy']);
});

// Creo esta ruta para las entradas no autorizadas
Route::get("no-autorizado", function () {
	return ["message" => "No tienes permiso para acceder a esta direccion"];
})->name("login");
