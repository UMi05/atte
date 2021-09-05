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
})->middleware('auth');

Auth::routes();

Route::get('/attendance', [AttendanceController::class, 'index'])->name('home');
//出退勤打刻
Route::post('/attendance/workin', [AttendanceController::class, 'workIn']);
Route::post('/attendance/workout', [AttendanceController::class, 'workOut']);

//休憩打刻
Route::post('/attendance/restin', [AttendanceController::class, 'restIn']);
Route::post('/attendance/restout', [AttendanceController::class, 'restOut']);

//日付一覧
Route::get('/attendance/check', [CheckController::class, 'index'])->name('check');