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

// Route::get('/', function () {
//     //return view('welcome');
// });

Auth::routes();

Route::get('/', [App\Http\Controllers\UrlController::class, 'index'])->name('index');
Route::post('/', [App\Http\Controllers\UrlController::class, 'store'])->name('store');
Route::post('/{id}', [App\Http\Controllers\UrlController::class, 'update'])->name('update');
Route::delete('/{id}', [App\Http\Controllers\UrlController::class, 'destroy'])->name('destroy');

