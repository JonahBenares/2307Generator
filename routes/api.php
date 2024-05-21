<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PayeesController;
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
Route::get('/login_form', [AuthController::class,'login_form']);
Route::post('/login_process', [AuthController::class,'login_process']);
//Route::get('/dashboard', [AuthController::class,'dashboard']);
Route::post('/add_payee',[PayeesController::class,'add_payee']);