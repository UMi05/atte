<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
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

Route::get('/', [HomeController::class, 'index'])->name('home');

//出退勤打刻
Route::post('/workin', [AttendanceController::class, 'workIn'])->name('workin');
Route::post('/workout', [AttendanceController::class, 'workOut'])->name('workout');
//休憩打刻
Route::post('/restin', [AttendanceController::class, 'restIn'])->name('restin');
Route::post('/restout', [AttendanceController::class, 'restOut'])->name('restout');

//日付一覧
Route::get('/attendance', [CheckController::class, 'index'])->name('attendance');