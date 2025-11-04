<?php

use function Pest\Laravel\get;

test('public navigation is displayed correctly', function () {
    $response = get('/');

    $response->assertStatus(200)
        ->assertSee('JobBoard')
        ->assertSee('Home')
        ->assertSee('Browse Jobs')
        ->assertSee('About')
        ->assertSee('Log in')
        ->assertSee('Register');
});

test('authenticated user sees dashboard link on public pages', function () {
    $user = \App\Models\User::factory()->create();

    $response = $this->actingAs($user)->get('/');

    $response->assertStatus(200)
        ->assertSee('JobBoard')
        ->assertSee('Dashboard')
        ->assertSee(ucfirst($user->role));
});
