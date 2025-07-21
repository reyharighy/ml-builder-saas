<?php

use App\Models\User;

test('datasets index screen can be rendered if the email is verified', function () {
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => '@Password123',
    ]);

    $this->actingAs($user)->post(route('login'), [
        'email' => $user->email,
        'password' => '@Password123',
    ]);

    $this->assertAuthenticated();

    $response = $this->actingAs($user)->get(route('datasets.index'));

    $response->assertStatus(200);
});

test('redirect the user to verify their email when accessing datasets index screen', function () {
    $user = User::factory()->unverified()->create([
        'email' => 'test@example.com',
        'password' => '@Password123',
    ]);

    $this->actingAs($user)->post(route('login'), [
        'email' => $user->email,
        'password' => '@Password123',
    ]);

    $this->assertAuthenticated();

    $response = $this->actingAs($user)->get(route('datasets.index'))
        ->assertRedirect(route('verification.notice'));

    $response->assertStatus(302);
});
