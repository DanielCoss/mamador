<?php

use App\Http\Controllers\EmpleadoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/index',[HomeController::class, 'index']);
Route::get('/index',[HomeController::class, 'index']);
Route::get('/calendario',[HomeController::class, 'calendario']);
Route::get('/empleado/{clave}', [EmpleadoController::class, 'ver_empleado']);
Route::post('/empleado/{clave}', [EmpleadoController::class, 'ver_empleado']);
Route::get('/importdata', [HomeController::class, 'add_data']);
Route::post('/importdata_save', [HomeController::class, 'import_data_file']);
Route::get('/test', function () {
    return view('modal');
});