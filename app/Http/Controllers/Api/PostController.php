<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePostRequest;
use App\Models\Post;
use App\Models\PostMedia;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Post::with('images')->orderBy('created_at','desc')->paginate(10);
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
    public function store(CreatePostRequest $request)
    {
        try{
            $post = Post::create([
                'title'=>$request->title,
                'content'=>$request->content,
                'slug'=>$request->title,
                'user_id'=>auth()->id(),
            ]);
            if($post){
                if($request->images){
                    foreach($request->images as $image){
                        //upload each image to s3 bucket
                        $value = Storage::disk('s3')->put('/',$image);
                        //attach image with the post
                        PostMedia::create([
                            'post_id'=>$post->id,
                            'media_url'=>$value,
                            'type'=>'image'
                        ]);
                    }
                }

                return response()->json([
                    'message'=>'Successfully created post!',
                    'post'=> $post->load('images'),
                ],200);
            }
        }catch(Exception $ex){
            return response()->json([
                'message'=> "Something went wrong!",
            ],500);
        }
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
    public function update(Request $request, Post $post)
    {
        try{
            if($post->update($request->all())){
                return response()->json([
                    'message'=>'Successfully Updated Post!',
                    'post'=> $post->load('images'),
                ],200);
            }
        }catch(Exception $ex){
            return response()->json([
                'message'=> "Something went wrong!",
            ],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if(auth()->user()->hasRole('admin') || $post->user_id === auth()->id()){
            if($post->delete()){
                return response()->json([
                    'message'=>'Successfully deleted Post!'
                ],200);
            }else{
                return response()->json([
                    'message'=> "Something went wrong!",
                ],500);
            }
        }else{
            return response()->json([
                'message'=>'Can not deleted Post!'
            ],200);
        }
    }
}
