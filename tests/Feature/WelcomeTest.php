<?php

use App\Models\User;

test('home screen can be rendered as guests', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200);
});

test('home screen can be rendered as authenticated users', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('home'));

    $response->assertStatus(200);
});