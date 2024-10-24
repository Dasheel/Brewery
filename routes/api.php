<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BreweryController;

Route::post('/sign-in', [AuthController::class, 'signIn'])->name('sign-in');

Route::middleware('auth:sanctum')->get('/breweries-list', [BreweryController::class, 'index'])->name('breweries-list');
