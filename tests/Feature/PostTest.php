<?php

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Str;

// --- Index ---

test('guests cannot view posts index', function () {
    $this->get(route('post.index'))->assertRedirect(route('login'));
});

test('authenticated users can view all blog posts', function () {
    $user  = User::factory()->create();
    $posts = Post::factory(3)->create();

    $this->actingAs($user)
        ->get(route('post.index'))
        ->assertOk()
        ->assertSeeText(Str::words($posts[0]->body, 5, ''));
});

test('index shows blog posts from all users', function () {
    $userA = User::factory()->create();
    $userB = User::factory()->create();

    $postA = Post::factory()->create(['user_id' => $userA->id]);
    $postB = Post::factory()->create(['user_id' => $userB->id]);

    $this->actingAs($userA)
        ->get(route('post.index'))
        ->assertSeeText(substr($postA->body, 0, 20))
        ->assertSeeText(substr($postB->body, 0, 20));
});

// --- Create / Store ---

test('authenticated users can view the create blog post form', function () {
    $this->actingAs(User::factory()->create())
        ->get(route('post.create'))
        ->assertOk();
});

test('authenticated users can create a blog post', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('post.store'), ['body' => 'My new blog post'])
        ->assertRedirect();

    $this->assertDatabaseHas('posts', ['body' => 'My new blog post', 'user_id' => $user->id]);
});

test('body is required when creating a blog post', function () {
    $this->actingAs(User::factory()->create())
        ->post(route('post.store'), ['body' => ''])
        ->assertSessionHasErrors('body');
});

// --- Show ---

test('any authenticated user can view any blog post', function () {
    $viewer = User::factory()->create();
    $post   = Post::factory()->create();

    $this->actingAs($viewer)
        ->get(route('post.show', $post))
        ->assertOk()
        ->assertSeeText($post->body);
});

// --- Edit / Update ---

test('owner can edit their blog post', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);

    $this->actingAs($user)
        ->get(route('post.edit', $post))
        ->assertOk();
});

test('non-owner cannot edit someone elses blog post', function () {
    $post  = Post::factory()->create();
    $other = User::factory()->create();

    $this->actingAs($other)
        ->get(route('post.edit', $post))
        ->assertForbidden();
});

test('owner can update their blog post', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);

    $this->actingAs($user)
        ->put(route('post.update', $post), ['body' => 'Updated content'])
        ->assertRedirect();

    $this->assertDatabaseHas('posts', ['id' => $post->id, 'body' => 'Updated content']);
});

test('non-owner cannot update someone elses blog post', function () {
    $post  = Post::factory()->create();
    $other = User::factory()->create();

    $this->actingAs($other)
        ->put(route('post.update', $post), ['body' => 'Hacked'])
        ->assertForbidden();
});

// --- Delete ---

test('owner can delete their blog post', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);

    $this->actingAs($user)
        ->delete(route('post.destroy', $post))
        ->assertRedirect();

    $this->assertDatabaseMissing('posts', ['id' => $post->id]);
});

test('non-owner cannot delete someone elses blog post', function () {
    $post  = Post::factory()->create();
    $other = User::factory()->create();

    $this->actingAs($other)
        ->delete(route('post.destroy', $post))
        ->assertForbidden();
});
