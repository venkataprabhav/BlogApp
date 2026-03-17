<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostVote;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate();

        return response()->json($posts);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'body' => ['required', 'string'],
        ]);

        $data['user_id'] = $request->user()->id;
        $post = Post::create($data);

        return response()->json($post, 201);
    }

    public function show(Post $post)
    {
        return response()->json($post->load('user'));
    }

    public function update(Request $request, Post $post)
    {
        if ($post->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden.'], 403);
        }

        $data = $request->validate([
            'body' => ['required', 'string'],
        ]);

        $post->update($data);

        return response()->json($post);
    }

    public function destroy(Request $request, Post $post)
    {
        if ($post->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden.'], 403);
        }

        $post->delete();

        return response()->json(['message' => 'Blog post deleted.']);
    }

    public function vote(Request $request, Post $post, string $type)
    {
        if (! in_array($type, ['like', 'dislike'])) {
            return response()->json(['message' => 'Invalid vote type.'], 422);
        }

        $userId   = $request->user()->id;
        $existing = PostVote::where('user_id', $userId)->where('post_id', $post->id)->first();

        if ($existing) {
            if ($existing->vote === $type) {
                $existing->delete();
                $action = 'removed';
            } else {
                $existing->update(['vote' => $type]);
                $action = 'updated';
            }
        } else {
            PostVote::create(['user_id' => $userId, 'post_id' => $post->id, 'vote' => $type]);
            $action = 'added';
        }

        return response()->json([
            'message'  => "Vote {$action}.",
            'likes'    => $post->votes()->where('vote', 'like')->count(),
            'dislikes' => $post->votes()->where('vote', 'dislike')->count(),
        ]);
    }
}
