<?php

use App\Http\Controllers\API\V1\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CompaniesController;

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

Route::prefix('/v1')->group(function () {
    Route::apiResource('/task', TaskController::class);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// route for print 'test'
Route::get('/test', function () {
    return (response()->json([
        'message' => 'worker found',
        'data' => 'Mohamed',
        'status' => '401'
    ], 400));
});
//add route for sign up to company controller
Route::post('/company/register', [CompaniesController::class, 'signUp']);
//add route for login to company controller
Route::post('/company/login', [CompaniesController::class, 'login']);
