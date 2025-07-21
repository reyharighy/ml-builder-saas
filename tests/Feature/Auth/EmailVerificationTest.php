<?php

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;

test('user is redirected to email verification screen if their email is unverified upon visiting dataset path', function () {
    $user = User::factory()->unverified()->create([
        'password' => '@Password123',
    ]);

    $response = $this->actingAs($user)->post(route('login'), [
        'email' => $user->email,
        'password' => '@Password123',
    ]);

    $this->assertAuthenticated();

    $response = $this->actingAs($user)
        ->get(route('datasets.index'))
        ->assertRedirect(route('verification.notice'));

    $response->assertStatus(302);
});

test('user is redirected to email verification screen if their email is unverified upon visiting project path', function () {
    $user = User::factory()->unverified()->create([
        'password' => '@Password123',
    ]);

    $this->actingAs($user)->post(route('login'), [
        'email' => $user->email,
        'password' => '@Password123',
    ]);

    $this->assertAuthenticated();

    $response = $this->actingAs($user)
        ->get(route('projects.index'))
        ->assertRedirect(route('verification.notice'));

    $response->assertStatus(302);
});

test('email verification notification is sent to unverified user', function () {
    Notification::fake();

    $user = User::factory()->unverified()->create([
        'password' => '@Password123',
    ]);

    $this->actingAs($user)->post(route('login'), [
        'email' => $user->email,
        'password' => '@Password123',
    ]);

    $this->assertAuthenticated();

    $this->actingAs($user)
        ->post(route('verification.send'))
        ->assertSessionHas('status', 'verification-link-sent');

    Notification::assertSentTo($user, VerifyEmail::class);
});

test('email verification notification is not sent to verified user', function () {
    $user = User::factory()->create([
        'password' => '@Password123',
    ]);

    $this->actingAs($user)->post(route('login'), [
        'email' => $user->email,
        'password' => '@Password123',
    ]);

    $this->assertAuthenticated();

    $this->actingAs($user)
        ->post(route('verification.send'))
        ->assertRedirect(route('dashboard', absolute: false));
});

test('email can be verified', function () {
    $user = User::factory()->unverified()->create();

    Event::fake();

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $user->id, 'hash' => sha1($user->email)]
    );

    $response = $this->actingAs($user)->get($verificationUrl);

    Event::assertDispatched(Verified::class);
    expect($user->fresh()->hasVerifiedEmail())->toBeTrue();
    $response->assertRedirect(route('dashboard', absolute: false).'?verified=1');
});

test('email is not verified with invalid hash', function () {
    $user = User::factory()->unverified()->create();

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $user->id, 'hash' => sha1('wrong-email')]
    );

    $this->actingAs($user)->get($verificationUrl);

    expect($user->fresh()->hasVerifiedEmail())->toBeFalse();
});
