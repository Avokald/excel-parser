<?php

use App\Http\Controllers\RowController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/rows', [RowController::class,'index'])->name('index');

Route::get('/upload', [RowController::class, 'upload'])->name('upload');

Route::post('/process', [RowController::class, 'process'])->name('process');
