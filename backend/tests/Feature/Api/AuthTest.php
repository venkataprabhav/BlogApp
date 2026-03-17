<?php

use App\Models\User;
use Laravel\Passport\Passport;

beforeEach(function () {
    \Laravel\Passport\Client::forceCreate([
        'id'            => \Illuminate\Support\Str::uuid(),
        'name'          => 'Test Personal Access Client',
        'secret'        => \Illuminate\Support\Str::random(40),
        'provider'      => 'users',
        'redirect_uris' => [],
        'grant_types'   => ['personal_access'],
        'revoked'       => false,
    ]);
});

test('user can register via api', function () {
    $this->postJson('/api/register', [
        'name'                  => 'John Doe',
        'email'                 => 'john@example.com',
        'password'              => 'password123',
        'password_confirmation' => 'password123',
    ])
        ->assertCreated()
        ->assertJsonStructure(['user', 'token']);

    $this->assertDatabaseHas('users', ['email' => 'john@example.com']);
});

test('registration requires all fields', function () {
    $this->postJson('/api/register', [])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['name', 'email', 'password']);
});

test('registration requires a unique email', function () {
    User::factory()->create(['email' => 'john@example.com']);

    $this->postJson('/api/register', [
        'name'                  => 'John Doe',
        'email'                 => 'john@example.com',
        'password'              => 'password123',
        'password_confirmation' => 'password123',
    ])->assertUnprocessable()
      ->assertJsonValidationErrors(['email']);
});

test('user can login via api', function () {
    $user = User::factory()->create(['password' => bcrypt('password123')]);

    $this->postJson('/api/login', [
        'email'    => $user->email,
        'password' => 'password123',
    ])
        ->assertOk()
        ->assertJsonStructure(['user', 'token']);
});

test('login fails with wrong password', function () {
    $user = User::factory()->create(['password' => bcrypt('password123')]);

    $this->postJson('/api/login', [
        'email'    => $user->email,
        'password' => 'wrongpassword',
    ])->assertUnprocessable();
});

test('authenticated user can fetch their own profile', function () {
    $user = User::factory()->create();
    Passport::actingAs($user);

    $this->getJson('/api/me')
        ->assertOk()
        ->assertJsonFragment(['email' => $user->email]);
});

test('authenticated user can logout', function () {
    $user = User::factory()->create();
    Passport::actingAs($user);

    $this->postJson('/api/logout')
        ->assertOk()
        ->assertJsonFragment(['message' => 'Logged out successfully.']);
});

test('unauthenticated requests to protected routes are rejected', function () {
    $this->getJson('/api/me')->assertUnauthorized();
});
