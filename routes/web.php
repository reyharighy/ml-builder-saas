<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function (Request $request) {
    return Inertia::render('Dashboard', [
        'routeName' => $request->route()->getName(),
    ]);
})->middleware('auth')->name('dashboard');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
require __DIR__.'/datasets.php';
require __DIR__.'/projects.php';
