<?php

use App\Models\User;

test('login screen can be rendered', function () {
    $response = $this->get(route('login'));

    $response->assertStatus(200);
});

test('users can authenticate using the login screen', function () {
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => '@Password123',
    ]);

    $response = $this->post(route('login'), [
        'email' => $user->email,
        'password' => '@Password123',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));
});

test('users can not authenticate with invalid email', function () {
    User::factory()->create([
        'email' => 'correct@email.com',
    ]);

    $this->post(route('login'), [
        'email' => 'invalid@email.com',
        'password' => '@Password123',
    ]);

    $this->assertGuest();
});

test('users can not authenticate with invalid password', function () {
    $user = User::factory()->create([
        'password' => '@Password123',
    ]);

    $this->post(route('login'), [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});

test('users can not authenticate with invalid email and password', function () {
    $user = User::factory()->create([
        'email' => 'correct@email.com',
        'password' => '@Password123',
    ]);

    $this->post(route('login'), [
        'email' => 'invalid@email.com',
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});

test('users can logout', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('logout'));

    $this->assertGuest();
    $response->assertRedirect('/');
});