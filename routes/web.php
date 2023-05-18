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



use App\Http\Controllers\ProductController;
//admin about Product
Route::get('admin/product', [ProductController::class, 'getProduct']);
Route::get('admin/productadd', [ProductController::class, 'productadd'])->name('admin/productadd');
Route::post('admin/product', [ProductController::class, 'AddProduct'])->name('admin.product');
Route::get('admin/productedit/{id}', [ProductController::class, 'editproduct']);
Route::post('admin/productedit/{id}', [ProductController::class, 'update']);
Route::get('admin/product_detail/{id}', [ProductController::class, 'viewDetailProduct'])->name('view_productdetail');