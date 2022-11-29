<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ProduitController;

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

Route::post('/inscription', [AuthController::class, 'register']);
Route::post('/connexion', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/deconnexion', [AuthController::class, 'disconnect']);

    // Liste de course
    Route::get('/courses', [CourseController::class, 'index']);
    Route::post('/course', [CourseController::class, 'create']);
    Route::get('/course/{course}', [CourseController::class, 'read']);
    Route::put('/course/{course}', [CourseController::class, 'update']);
    Route::delete('/course/{course}', [CourseController::class, 'delete']);

    // Produit
    Route::get('/produits/{course}', [ProduitController::class, 'index']);
    Route::post('/produit', [ProduitController::class, 'create']);
    Route::put('/produit/{produit}', [ProduitController::class, 'update']);
    Route::delete('/produit/{produit}', [ProduitController::class, 'delete']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
