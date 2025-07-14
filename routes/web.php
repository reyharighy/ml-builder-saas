<?php

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::post('upload-csv', function(FormRequest $request) {
    $request->validate(['csv_file' => 'required|mimes:csv']);

    $file = $request->file('csv_file');

    Storage::disk('shared')
        ->putFileAs(
            'datasets', $file, 
            $file->getClientOriginalName()
        );
})->name('upload-csv');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
