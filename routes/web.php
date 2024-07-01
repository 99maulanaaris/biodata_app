<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BiodataController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

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


Route::middleware('guest')->group(function(){
    Route::get('login',[AuthController::class,'login'])->name('login');
    Route::post('login',[AuthController::class,'authenticated'])->name('store.login');
    Route::get('register',[AuthController::class,'register'])->name('register');
    Route::post('register',[AuthController::class,'storeRegister'])->name('store.register');
});

Route::middleware('auth')->group(function(){
    Route::post('logout',[AuthController::class,'logout'])->name('logout');
    Route::get('/',[HomeController::class,'index'])->name('home');
    Route::get('/user',[HomeController::class,'dataUser'])->name('user');
    Route::get('/user/{id}',[HomeController::class,'editUser'])->name('user.edit');
    Route::post('/user/update',[HomeController::class,'store'])->name('user.update');
    Route::post('/user/datatable',[HomeController::class,'dataTable'])->name('user.datatable');
    Route::delete('/user/{id}',[HomeController::class,'destroy'])->name('user.destroy');
    Route::get('profile',[BiodataController::class,'index'])->name('profile');
    Route::post('profile',[BiodataController::class,'store'])->name('store.profile');
});
