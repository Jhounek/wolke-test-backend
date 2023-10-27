<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Exception;
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
        return Post::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $inputs = $request->input();
            $response = Post::create($inputs);
            return response()->json([
                'data'=> $response,
                'message'=> "Post created successfully"
            ]);
        }catch(Exception $m){
               return "Error creating the post... ->".$m;
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
        try{
         $result = Post::where('owner_id','=', $id)->get();
         $response = ($result && count($result) > 0)
            ?
             response()->json([
                'data'=> $result,
                'message'=> "Post found successfully"
            ])
            :
             response()->json([
                'Error'=> true,
                'message'=> "Posts didn't found"
            ]);
         return $response;
        }catch(Exception $m){
            return "Error getting the posts... ->".$m;
        }
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
        try{
            $result = Post::find($id);
            if(isset($result)){
                $result->title = $request->title;
                $result->description = $request->description;
                $result->image = $request->image;
                $result->save();
                return response()->json([
                    'data'=> $result,
                    'message'=> "Post updated successfully"
                ]);
            }else{
                return response()->json([
                    'Error'=> true,
                    'message'=> "Posts didn't found"
                ]);
            }
           }catch(Exception $m){
               return "Error updating the post... ->".$m;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Post::find($id);
        if(isset($user)){
            $res = Post::destroy($id);
            if($res){
                return response()->json([
                    'data'=> [],
                    'message'=> "Post deleted successfully"
                ]);
            }
        }else{
            return response()->json([
                'error'=> true,
                'message'=> "We couldn't delete the Post, try it again"
            ]);
        }
    }
}
