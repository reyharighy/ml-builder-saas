<?php

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

// test('authenticated users can upload dataset', function () {
//     Storage::fake('shared');

//     $user = User::factory()->create();

//     $this->actingAs($user);

//     $file = UploadedFile::fake()->create('test.csv', 100, 'text/csv');

//     $response = $this->post(route('upload-csv'), [
//         'csv_file' => $file,
//     ]);

//     expect(
//         Storage::disk('shared')
//             ->exists($user->id . '/' . $file->getClientOriginalName())
//     )->toBeTrue();

//     $response->assertStatus(302);
// });