<?php

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;

test('reset password link screen can be rendered', function () {
    $response = $this->get(route('password.request'));

    $response->assertStatus(200);
    $this->assertGuest();
});

test('reset password link can be requested and sent to the email of the user', function () {
    Notification::fake();

    $user = User::factory()->create();

    $this->post(route('password.email'), ['email' => $user->email]);

    Notification::assertSentTo($user, ResetPassword::class);
    $this->assertGuest();
});

test('reset password link cannot be requested because no such email input is registered', function () {
    $this->post(route('password.email'), ['email' => 'anonymous@email.com']);

    $this->assertGuest();
});

test('reset password link cannot be requested if the email is not in email format', function () {
    $response = $this->post(route('password.email'), ['email' => 'not-an-email']);

    $response->assertInvalid(['email']);
    $this->assertGuest();
});

test('reset password screen can be rendered from the link provided sent to the email of the user', function () {
    Notification::fake();

    $user = User::factory()->create();

    $this->post(route('password.email'), ['email' => $user->email]);

    Notification::assertSentTo($user, ResetPassword::class, function ($notification) {
        $response = $this->get(route('password.reset', ['token' => $notification->token]));

        $response->assertStatus(200);

        return true;
    });
});

test('password can be reset with valid token', function () {
    Notification::fake();

    $user = User::factory()->create();

    $this->post(route('password.email'), ['email' => $user->email]);

    Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($user) {
        $response = $this->post(route('password.store'), [
            'token' => $notification->token,
            'email' => $user->email,
            'password' => '@Password123',
            'password_confirmation' => '@Password123',
        ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('login'));

        return true;
    });
});

test('password cannnot be reset with invalid token', function () {
    Notification::fake();

    $user = User::factory()->create();

    $this->post(route('password.email'), ['email' => $user->email]);

    Notification::assertSentTo($user, ResetPassword::class, function () use ($user) {
        $response = $this->post(route('password.store'), [
            'token' => 'invalid-token',
            'email' => $user->email,
            'password' => '@Password123',
            'password_confirmation' => '@Password123',
        ]);

        $response
            ->assertSessionHasErrors()
            ->assertInvalid();

        return true;
    });
});