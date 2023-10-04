<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use Throwable;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::where('access', true);

        $inc_comm = request('comments');

        if($inc_comm){
            return PostResource::collection($posts->with('comments')->get());
        }

        return PostResource::collection($posts->get());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        return new PostResource(Post::create(array_merge($request->all(), ['user_id' => auth()->user()->id])));
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $access = $post->access;
        
        $inc_comm = request('comments');

        if($access){
            if($inc_comm){
                return new PostResource($post->loadMissing('comments'));
            }

            return new PostResource($post);
        }

        return response()->json([
            'message' => 'Post not found'
        ],401);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        try{
            $post->update($request->all());
            return response()->json([
                'message' => 'post has been publishing',
                // 'role' => auth()->user()->role
            ], 200);
        }
        catch (Throwable $th) {
            return response()->json([
                'errors' => $th->getMessage()
            ], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
