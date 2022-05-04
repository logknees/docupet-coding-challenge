<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Router;
use App\Http\Controllers\ControllerPet;

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

Route::post('/', 'App\Http\Controllers\ControllerPet@create')->middleware('cors');

//not used
// Route::patch('/', 'App\Http\Controllers\ControllerPet@update')->middleware('cors');
// Route::put('/', 'App\Http\Controllers\ControllerPet@upsert')->middleware('cors');

