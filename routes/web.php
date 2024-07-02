<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImportItemsController;
use App\Http\Controllers\PurposeController;
use App\Http\Controllers\EnduseController;
use App\Http\Controllers\ReportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/export-excel', [ImportItemsController::class, 'exportBegbal']);
Route::get('/export-inventory', [ImportItemsController::class, 'exportInventory']);
Route::get('/export-currentinventory', [ImportItemsController::class, 'exportCurrentInventory']);
Route::get('/export-purpose', [PurposeController::class, 'export_purpose']);
Route::get('/export-enduse', [EnduseController::class, 'export_enduse']);
Route::get('/export-generation-report/{date_from}/{date_to}/{date_encoded}/{payee}', [ReportController::class, 'export_generation_report']);
Route::get('/{pathMatch}', function(){
    return view('welcome');
})->where('pathMatch',".*");