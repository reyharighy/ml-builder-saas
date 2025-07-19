<?php

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

test('guests are redirected to the login page', function () {
    $response = $this->get('/dashboard');
    $response->assertRedirect('/login');
});

test('authenticated users can visit the dashboard', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get('/dashboard');
    $response->assertStatus(200);
});

test('authenticated users can upload dataset', function () {
    Storage::fake('shared');

    $user = User::factory()->create();
    $this->actingAs($user);

    $file = UploadedFile::fake()->create('test.csv', 100, 'text/csv');

    $response = $this->post(route('upload-csv'), [
        'csv_file' => $file,
    ]);

    expect(
        Storage::disk('shared')
            ->exists($user->id . '/' . $file->getClientOriginalName())
    )->toBeTrue();

    $response->assertStatus(302);
});