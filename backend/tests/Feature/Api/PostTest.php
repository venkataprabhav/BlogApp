<?php

use App\Models\Post;
use App\Models\PostVote;
use App\Models\User;
use Laravel\Passport\Passport;

// --- Index ---

test('authenticated user can fetch all blog posts via api', function () {
    Passport::actingAs(User::factory()->create());
    Post::factory(3)->create();

    $this->getJson('/api/posts')
        ->assertOk()
        ->assertJsonStructure(['data']);
});

test('unauthenticated user cannot fetch blog posts via api', function () {
    $this->getJson('/api/posts')->assertUnauthorized();
});

// --- Store ---

test('authenticated user can create a blog post via api', function () {
    $user = User::factory()->create();
    Passport::actingAs($user);

    $this->postJson('/api/posts', ['body' => 'My API blog post'])
        ->assertCreated()
        ->assertJsonFragment(['body' => 'My API blog post']);

    $this->assertDatabaseHas('posts', ['body' => 'My API blog post', 'user_id' => $user->id]);
});

test('body is required when creating a blog post via api', function () {
    Passport::actingAs(User::factory()->create());

    $this->postJson('/api/posts', ['body' => ''])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['body']);
});

// --- Show ---

test('authenticated user can view any blog post via api', function () {
    Passport::actingAs(User::factory()->create());
    $post = Post::factory()->create();

    $this->getJson("/api/posts/{$post->id}")
        ->assertOk()
        ->assertJsonFragment(['id' => $post->id]);
});

// --- Update ---

test('owner can update their blog post via api', function () {
    $user = User::factory()->create();
    Passport::actingAs($user);
    $post = Post::factory()->create(['user_id' => $user->id]);

    $this->putJson("/api/posts/{$post->id}", ['body' => 'Updated'])
        ->assertOk()
        ->assertJsonFragment(['body' => 'Updated']);
});

test('non-owner cannot update someone elses blog post via api', function () {
    $post = Post::factory()->create();
    Passport::actingAs(User::factory()->create());

    $this->putJson("/api/posts/{$post->id}", ['body' => 'Hacked'])
        ->assertForbidden();
});

// --- Delete ---

test('owner can delete their blog post via api', function () {
    $user = User::factory()->create();
    Passport::actingAs($user);
    $post = Post::factory()->create(['user_id' => $user->id]);

    $this->deleteJson("/api/posts/{$post->id}")->assertOk();

    $this->assertDatabaseMissing('posts', ['id' => $post->id]);
});

test('non-owner cannot delete someone elses blog post via api', function () {
    $post = Post::factory()->create();
    Passport::actingAs(User::factory()->create());

    $this->deleteJson("/api/posts/{$post->id}")->assertForbidden();
});

// --- Voting ---

test('authenticated user can like a blog post via api', function () {
    $user = User::factory()->create();
    Passport::actingAs($user);
    $post = Post::factory()->create();

    $this->postJson("/api/posts/{$post->id}/vote/like")
        ->assertOk()
        ->assertJsonFragment(['message' => 'Vote added.']);

    $this->assertDatabaseHas('post_votes', [
        'user_id' => $user->id,
        'post_id' => $post->id,
        'vote'    => 'like',
    ]);
});

test('voting the same way again removes the vote via api', function () {
    $user = User::factory()->create();
    Passport::actingAs($user);
    $post = Post::factory()->create();

    PostVote::create(['user_id' => $user->id, 'post_id' => $post->id, 'vote' => 'like']);

    $this->postJson("/api/posts/{$post->id}/vote/like")
        ->assertOk()
        ->assertJsonFragment(['message' => 'Vote removed.']);
});

test('voting with an invalid type returns an error via api', function () {
    Passport::actingAs(User::factory()->create());
    $post = Post::factory()->create();

    $this->postJson("/api/posts/{$post->id}/vote/invalid")
        ->assertUnprocessable();
});
