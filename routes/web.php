<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CheckController;

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
    return view('auth/login');
});

Auth::routes();

Route::get('/app/attendance', [AttendanceController::class, 'index'])->name('home');
//出退勤打刻
Route::post('/app/attendance', [AttendanceController::class, 'workin']);
Route::post('/app/attendance', [AttendanceController::class, 'workout']);
//休憩打刻
Route::post('/app/attendance', [AttendanceController::class, 'breakin']);
Route::post('/app/attendance', [AttendanceController::class, 'breakout']);

//日付一覧
Route::get('/app/check', [CheckController::class, 'index'])->name('check');