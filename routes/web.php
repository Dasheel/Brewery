<?php

use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/breweries', function () {
    return view('breweries');
})->name('breweries.view');
