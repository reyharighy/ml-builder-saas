<?php

use App\Http\Controllers\Projects\ProjectController;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('projects', ProjectController::class);

    Route::post('upload-csv', function(FormRequest $request) {
        $request->validate(['csv_file' => 'required|mimes:csv']);

        $file = $request->file('csv_file');

        Storage::disk('shared')
            ->putFileAs(
                Auth::user()->id, $file,
                'dataset.csv'
            );

        return back()->with('status', 'dataset-uploaded');
    })->name('upload-csv');
});
