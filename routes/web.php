<?php

use App\Http\Controllers\TrafficLightController;
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

// Route to display the traffic lights page
Route::get('/traffic', [TrafficLightController::class, 'index']);

// Route to handle the log request (POST)
Route::post('/log', [TrafficLightController::class, 'log']);
