<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class LoveController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $post->loves()->create([
            'user_id' => $request->user()->id
        ]);

        return back();
    }

    public function destroy(Request $request, Post $post)
    {
        $request->user()->loves()->where('post_id', $post->id)->delete();

        return back();
    }
}
