<?php

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function (Request $request) {
    return Inertia::render('Dashboard', [
        'status' => $request->session()->get('status'),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::post('upload-csv', function(FormRequest $request) {
    $request->validate(['csv_file' => 'required|mimes:csv']);

    $file = $request->file('csv_file');

    Storage::disk('shared')
        ->putFileAs(
            Auth::user()->id, $file,
            $file->getClientOriginalName()
        );

    return back()->with('status', 'dataset-uploaded');
})->name('upload-csv');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
