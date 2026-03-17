<?php

use App\Models\Post;
use App\Models\PostVote;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);

/** @var Tests\TestCase $this */
test('post belongs to a user', function () {
    $post = Post::factory()->create();

    expect($post->user)->toBeInstanceOf(User::class);
});

test('post has many votes', function () {
    $post  = Post::factory()->create();
    $users = User::factory(3)->create();

    foreach ($users as $user) {
        PostVote::create(['user_id' => $user->id, 'post_id' => $post->id, 'vote' => 'like']);
    }

    expect($post->votes)->toHaveCount(3);
});

test('userVote returns the authenticated users vote on a post', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create();

    PostVote::create(['user_id' => $user->id, 'post_id' => $post->id, 'vote' => 'like']);

    $this->actingAs($user);

    expect($post->userVote->vote)->toBe('like');
});

test('userVote returns null when user has not voted', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create();

    $this->actingAs($user);

    expect($post->userVote)->toBeNull();
});
