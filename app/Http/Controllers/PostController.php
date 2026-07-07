<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePostStatusRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $posts = Post::whereHas(
            'rawContent',
            fn ($query) =>
            $query->where(
                'user_id',
                $request->user()->id
            )
        )->get();

        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return new PostResource($post);
    }


    /**
     * Update the specified resource in storage.
     */
    public function updateStatus(UpdatePostStatusRequest $request, Post $post)
    {
        $post->update([
            'status' => $request->validated()['status']
        ]);

        return response()->json([
            'message' => 'Post status updated successfully',
            'post' => new PostResource($post)
        ]);
    }

}
