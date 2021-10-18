<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Posts;
class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $post = Posts::all();
 
        return response()->json([
            'success' => true,
            'data' => $post
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'title' => 'required',
            'content' => 'required'
        ]);

        $user_id = auth()->user()->id;
        $data_posts = array(
            "user_id"   => $user_id,
            "title" =>$request->title,
            "content" =>$request->content,
        );

        $create_posts = Posts::create($data_posts);


        if (!is_null($create_posts))
            return response()->json([
                'success' => true,
                'data' => $create_posts->toArray()
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Post not added'
            ], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $posts = Posts::find($id);

        if (!is_null($posts)) {
            # code...
            return response()->json([
                'success' => true,
                'data'    => $posts
            ]);
        }
        else{
            return response()->json([
                'success' => false,
                'message' => 'user not Find'
            ],500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $posts = Posts::find($id);
 
        if (!$posts) {
            return response()->json([
                'success' => false,
                'message' => 'posts not found'
            ], 400);
        }
 
        $updated = $posts->update($request->all());
 
        if ($updated)
            return response()->json([
                'success' => true
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'posts can not be updated'
            ], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $posts = Posts::find($id);
 
        if (!$posts) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 400);
        }
 
        if ($posts->delete()) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'User can not be deleted'
            ], 500);
        }
    }
}
