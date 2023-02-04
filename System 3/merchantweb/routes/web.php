<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;

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

Route::get('/products/{product}', [ProductController::class, 'otp'])->middleware('auth');

Route::get('/products/{product}/buy', [ProductController::class, 'buy'])->middleware('auth');

Route::get('/success', [ProductController::class, 'success'])->middleware('auth');

Route::get('/fail', [ProductController::class, 'fail'])->middleware('auth');

Route::get('/register', [UserController::class, 'create'])->middleware('guest');

Route::post('/users', [UserController::class, 'store']);

Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');

Route::post('/users/authenticate', [UserController::class, 'authenticate']);

Route::get('/', [ProductController::class, 'index'])->middleware('auth');
