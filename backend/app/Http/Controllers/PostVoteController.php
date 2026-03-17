<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostVote;
use Illuminate\Http\Request;

class PostVoteController extends Controller
{
    public function vote(Request $request, Post $post, string $type)
    {
        $userId = $request->user()->id;
        $existing = PostVote::where('user_id', $userId)->where('post_id', $post->id)->first();

        if ($existing) {
            if ($existing->vote === $type) {
                $existing->delete();
            } else {
                $existing->update(['vote' => $type]);
            }
        } else {
            PostVote::create([
                'user_id' => $userId,
                'post_id' => $post->id,
                'vote'    => $type,
            ]);
        }

        return back();
    }
}
