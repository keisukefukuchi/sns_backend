<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use App\Models\User;



use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Post::with(['user:id,name,uid'])->get();
        return response()->json([
            'data' => $items
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $uid = $request->uid;
        $user = User::where('uid','=',$uid)->first();
        $items = Post::create([
            'message' => $request->message,
            'user_id' => $user->id,
        ]);
        return response()->json([
            'data' => $items
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $item = Post::find($post);
        if ($item) {
            return response()->json([
                'data' => $item
            ], 200);
        } else {
            return response()->json([
                'name' => 'Not found',
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $update = [
            'name' => $request->name,
        ];
        $item = Post::where('id', $post->id)->update($update);
        if ($item) {
            return response()->json([
                'name' => 'Updated successfully',
            ], 200);
        } else {
            return response()->json([
                'name' => 'Not found',
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $like_id = Like::where('post_id', $post->id)->delete();
        $item = Post::where('id', $post->id)->delete();
        if ($item) {
            return response()->json([
                'name' => 'Deleted successfully',
            ], 200);
        } else {
            return response()->json([
                'name' => 'Not found',
            ], 404);
        }
    }
}
