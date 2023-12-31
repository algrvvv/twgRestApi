<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Http\Requests\createCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\Request;
use Throwable;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::where('access', true);

        $res = PostResource::collection($posts->get());

        if (count($res)) {
            $inc_comm = request('comments');

            if ($inc_comm) {
                return PostResource::collection($posts->with('comments')->get());
            }

            return $res;
        }

        return response()->json([
            'message' => 'there is not a single approved post'
        ], 200);
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

        if ($access) {
            if ($inc_comm) {
                return new PostResource($post->loadMissing('comments'));
            }

            return new PostResource($post);
        }

        return response()->json([
            'message' => 'Post not found'
        ], 401);
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
        try {
            $post->update($request->all());
            return response()->json([
                'message' => 'post has been publishing',
                // 'role' => auth()->user()->role
            ], 200);
        } catch (Throwable $th) {
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

        $user = auth()->user();

        if ($user->tokenCan('post:update', 'post:delete')) {
            try {
                $res = $post->delete();
                if ($res) {
                    return response()->json([
                        'message' => 'post has been deleted'
                    ], 200);
                }

                return response()->json([
                    'message' => 'post has not been deleted'
                ], 401);
            } catch (Throwable $th) {
                return response()->json([
                    'errors' => $th->getMessage()
                ], 401);
            }
        }

        return response()->json([
            'message' => 'you dont have a permisson'
        ]);
    }

    public function createComment(createCommentRequest $request, $id)
    {
        return new CommentResource(Comment::create(array_merge($request->all(), [
            'post_id' => $id, 'user_id' => auth()->user()->id
        ])));
    }
}
