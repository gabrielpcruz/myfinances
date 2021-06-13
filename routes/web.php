<?php

use App\Http\Controllers\Auth\Authentication;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', [HomeController::class, "index"])->middleware('auth');

Route::get('/login', [Authentication::class, 'index'])->name('login');
Route::post('/login', [Authentication::class, 'login']);

Route::get('/register', [Authentication::class, 'create']);
Route::post('/register', [Authentication::class, 'store']);

Route::get('/logout', function () {
    Auth::logout();
    return redirect('/login');
});

Route::get('/forgot', [Authentication::class, 'forgot']);

Route::get('/account/create', [AccountController::class, "create"])->middleware('auth');
Route::post('/account/store', [AccountController::class, "store"])->middleware('auth');

Route::get('/account/complete/{id}', [AccountController::class, "complete"])->middleware('auth');

Route::get('/account/edit/{id}', [AccountController::class, "edit"])->middleware('auth');
Route::post('/account/update', [AccountController::class, "update"])->middleware('auth');

Route::get('/deposit', [AccountController::class, "deposit"])->middleware('auth');
Route::post('/deposit/store', [AccountController::class, "depositStore"])->middleware('auth');

Route::get('/draft', [AccountController::class, "draft"])->middleware('auth');
Route::post('/draft/store', [AccountController::class, "draftStore"])->middleware('auth');

Route::get('/transfer', [AccountController::class, "transfer"])->middleware('auth');
Route::post('/transfer/store', [AccountController::class, "transferStore"])->middleware('auth');

Route::get('/report', [ReportController::class, "index"])->middleware('auth');
Route::post('/report/show', [ReportController::class, "show"])->middleware('auth');

Route::get('/backup', [BackupController::class, "index"])->middleware('auth');
Route::post('/report/show', [ReportController::class, "show"])->middleware('auth');

Route::fallback(function () {
    return view('error.404');
});
