<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // List logged-in user's posts
    public function index(Request $request)
    {
        return $request->user()->posts;
    }

    // Create a new post
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $post = $request->user()->posts()->create([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return response()->json($post, 201);
    }
public function show(Request $request, Post $post)
{
    if ($post->user_id !== $request->user()->id) {
        return response()->json(['message' => 'Unauthorized'], 403);
    }

    return response()->json($post);
}

    // Update a post (only if belongs to user)
    public function update(Request $request, Post $post)
    {
        if ($post->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $post->update($request->only('title', 'content'));

        return response()->json($post);
    }

    // Delete a post (only if belongs to user)
    public function destroy(Request $request, Post $post)
    {
        if ($post->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $post->delete();

        return response()->json(['message' => 'Post deleted']);
    }
}
