<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AccountController;

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

Route::get('/', [HomeController::class, "index"]);


Route::get('/account/create', [AccountController::class, "create"]);
Route::post('/account/store', [AccountController::class, "store"]);
Route::get('/account/edit/{id}', [AccountController::class, "edit"]);
Route::post('/account/update', [AccountController::class, "update"]);
