<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PayeesController;
use App\Http\Controllers\AtcController;
use App\Http\Controllers\AccountantController;
use App\Http\Controllers\DashboardController;
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

Route::post('/add_accountant',[AccountantController::class,'add_accountant']);
Route::get('/get_all_accountant',[AccountantController::class,'all_accountant']);
Route::get('/search_accountant',[AccountantController::class,'search_accountant']);
Route::get('/edit_accountant/{id}',[AccountantController::class,'edit_accountant']);
Route::post('/update_accountant/{id}',[AccountantController::class,'update_accountant']);

Route::get('/get_dropdown',[DashboardController::class,'get_dropdown']);
Route::get('/get_drafts/{id}/{detail_id}',[DashboardController::class,'get_drafts']);
Route::get('/get_atc_details/{id}',[DashboardController::class,'get_atc_details']);
Route::get('/get_payee_details/{id}',[DashboardController::class,'get_payee_details']);
Route::get('/get_amount/{detail_id}',[DashboardController::class,'get_amount']);
Route::post('/add_generation',[DashboardController::class,'add_generation']);
Route::post('/edit_generation',[DashboardController::class,'edit_generation']);
Route::get('/get_accountant_details',[DashboardController::class,'get_accountant_details']);
Route::get('/get_print_details/{id}',[DashboardController::class,'get_print_details']);
Route::get('/save_set/{id}',[DashboardController::class,'save_set']);
Route::get('/get_print_all/{id}',[DashboardController::class,'get_print_all']);