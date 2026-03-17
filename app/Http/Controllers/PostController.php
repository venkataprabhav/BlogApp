<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::query()
            ->with(['userVote', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate();
        return view('post.index', ['posts' => $posts]);
    }

    public function create()
    {
        return view('post.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'body' => ['required', 'string']
        ]);

        $data['user_id'] = $request->user()->id;
        $post = Post::create($data);

        return to_route('post.show', $post)->with('message', 'Blog post was created.');
    }

    public function show(Post $post)
    {
        $post->load(['userVote', 'user']);
        return view('post.show', ['post' => $post]);
    }

    public function edit(Post $post)
    {
        if ($post->user_id !== request()->user()->id) {
            abort(403);
        }
        return view('post.edit', ['post' => $post]);
    }

    public function update(Request $request, Post $post)
    {
        if ($post->user_id !== request()->user()->id) {
            abort(403);
        }
        $data = $request->validate([
            'body' => ['required', 'string']
        ]);

        $post->update($data);

        return to_route('post.show', $post)->with('message', 'Blog post was updated.');
    }

    public function destroy(Post $post)
    {
        if ($post->user_id !== request()->user()->id) {
            abort(403);
        }
        $post->delete();

        return to_route('post.index')->with('message', 'Blog post was deleted.');
    }
}
