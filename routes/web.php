<?php

use Illuminate\Support\Facades\Route;

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

//Login
use App\Http\Controllers\CustomAuthController;

Route::get('/login', [CustomAuthController::class, 'index'])->name('login');



//reset password

use App\Http\Controllers\ForgetPasswordController;

Route::get('forgetpassword', [ForgetPasswordController::class, 'forget_password'])->name('forget.password'); 
Route::post('login', [ForgetPasswordController::class, 'submitForgetPasswordForm'])->name('resetpassword'); 
