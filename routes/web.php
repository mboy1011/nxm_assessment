<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Report;

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

Route::get('/',[Report::class,'commission']);
Route::post('/show',[Report::class,'show']);
Route::get('/rank',[Report::class,'rank']);
