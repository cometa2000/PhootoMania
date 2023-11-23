<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class DislikeController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $post->dislikes()->create([
            'user_id' => $request->user()->id
        ]);

        return back();
    }

    public function destroy(Request $request, Post $post)
    {
        $request->user()->dislikes()->where('post_id', $post->id)->delete();

        return back();
    }

}
