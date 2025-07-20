<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;

test('registration screen can be rendered', function () {
    $response = $this->get(route('register'));

    $response->assertStatus(200);
});

test('new users can register', function () {
    Event::fake();

    $response = $this->post(route('register'), [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => '@Password123',
        'password_confirmation' => '@Password123',
    ]);

    Event::assertDispatched(Registered::class);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));
});

test('email registered should be unique', function () {
    User::factory()->create([
        'email' => 'registered@email.com',
    ]);
    
    $this->post(route('register'), [
        'name' => 'Test User',
        'email' => 'registered@email.com',
        'password' => '@Password123',
        'password_confirmation' => '@Password123',
    ]);

    $this->assertGuest();
});

test('email registered should not be capital case', function () {
    $this->post(route('register'), [
        'name' => 'Test User',
        'email' => 'CapitalCase@email.com',
        'password' => '@Password123',
        'password_confirmation' => '@Password123',
    ]);

    $this->assertGuest();
});

test('email should be in email format', function () {
    $this->post(route('register'), [
        'name' => 'Test User',
        'email' => 'notemail',
        'password' => '@Password123',
        'password_confirmation' => '@Password123',
    ]);

    $this->assertGuest();
});

test('users cannot register if not following password rules', function () {
    $this->post(route('register'), [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'not-satisfied-password',
        'password_confirmation' => 'not-satisfied-password',
    ]);

    $this->assertGuest();
});
