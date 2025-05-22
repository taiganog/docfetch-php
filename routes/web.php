<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::group(['middleware' => 'auth', 'verified'], function () {

    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('search', function () {
        return Inertia::render('Search');
    })->name('search');

    Route::get('upload', function () {
        return Inertia::render('Upload');
    })->name('upload');

});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
