<?php

use App\Models\Post;
use App\Models\PostVote;
use App\Models\User;

test('authenticated user can like a blog post', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create();

    $this->actingAs($user)
        ->post(route('post.vote', [$post, 'like']))
        ->assertRedirect();

    $this->assertDatabaseHas('post_votes', [
        'user_id' => $user->id,
        'post_id' => $post->id,
        'vote'    => 'like',
    ]);
});

test('authenticated user can dislike a blog post', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create();

    $this->actingAs($user)
        ->post(route('post.vote', [$post, 'dislike']))
        ->assertRedirect();

    $this->assertDatabaseHas('post_votes', [
        'user_id' => $user->id,
        'post_id' => $post->id,
        'vote'    => 'dislike',
    ]);
});

test('voting the same way again removes the vote', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create();

    PostVote::create(['user_id' => $user->id, 'post_id' => $post->id, 'vote' => 'like']);

    $this->actingAs($user)
        ->post(route('post.vote', [$post, 'like']));

    $this->assertDatabaseMissing('post_votes', [
        'user_id' => $user->id,
        'post_id' => $post->id,
    ]);
});

test('voting the opposite way switches the vote', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create();

    PostVote::create(['user_id' => $user->id, 'post_id' => $post->id, 'vote' => 'like']);

    $this->actingAs($user)
        ->post(route('post.vote', [$post, 'dislike']));

    $this->assertDatabaseHas('post_votes', [
        'user_id' => $user->id,
        'post_id' => $post->id,
        'vote'    => 'dislike',
    ]);
});

test('guests cannot vote', function () {
    $post = Post::factory()->create();

    $this->post(route('post.vote', [$post, 'like']))
        ->assertRedirect(route('login'));
});
