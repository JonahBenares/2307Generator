<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PayeesController;
use App\Http\Controllers\AtcController;
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
Route::get('/get_all_payee',[PayeesController::class,'all_payee']);
Route::get('/search_payee',[PayeesController::class,'search_payee']);
Route::get('/edit_payee/{id}',[PayeesController::class,'edit_payee']);
Route::post('/update_payee/{id}',[PayeesController::class,'update_payee']);

Route::post('/add_atc',[AtcController::class,'add_atc']);
Route::get('/get_all_atc',[AtcController::class,'all_atc']);
Route::get('/search_atc',[AtcController::class,'search_atc']);
Route::get('/edit_atc/{id}',[AtcController::class,'edit_atc']);
Route::post('/update_atc/{id}',[AtcController::class,'update_atc']);