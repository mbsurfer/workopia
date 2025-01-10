<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobController;

Route::get('/', [HomeController::class, 'index']);

Route::get('/jobs/saved', [JobController::class, 'saved']);
Route::resource('jobs', JobController::class);
