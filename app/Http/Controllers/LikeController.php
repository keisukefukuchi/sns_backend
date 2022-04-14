<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use App\Models\User;


use Illuminate\Http\Request;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Like::all();
        return response()->json([
            'data' => $items
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $uid = $request->input('uid');
        $user = User::all()->where('uid','=',$uid)->first();
        $user_id = $user->id;

        $param = [
            'user_id' => $user_id,
            'post_id' => $request->post_id,
        ];
        $get_query = Like::where([
            ['user_id', $user_id],
            ['post_id', $request->post_id]
        ])->first();

        if ($get_query) {
            $item = Like::where([
                ['user_id', $user_id],
                ['post_id', $request->post_id]
            ])->delete();

            $post = Post::find($request->post_id)->first();

            $like_count = $post->like_count;

            $like_count--;

            $update = [
                'like_count' => $like_count,
            ];

            $item = Post::where('id', $request->post_id)->update($update);
        } else {
            $item = Like::create($param);
            $post = Post::find($request->post_id)->first();
            $like_count = $post->like_count;
            $like_count++;
            $update = [
                'like_count' => $like_count,
            ];
            $item = Post::where('id', $request->post_id)->update($update);
        }

        return response()->json([
            'data' => $item
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Like  $like
     * @return \Illuminate\Http\Response
     */
    public function show(Like $like)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Like  $like
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Like $like)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Like  $like
     * @return \Illuminate\Http\Response
     */
    public function destroy(Like $like)
    {
        //
    }
}
