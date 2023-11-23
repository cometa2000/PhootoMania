<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $post->reports()->create([
            'user_id' => $request->user()->id
        ]);

        return back();
    }

    public function destroy(Request $request, Post $post)
    {
        $request->user()->reports()->where('post_id', $post->id)->delete();

        return back();
    }
}
