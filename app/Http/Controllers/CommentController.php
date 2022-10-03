<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $validate = Validator::make($request->all(),[
            'user_id' => 'required|integer|exists:users,id',
            'short_id' => 'required|integer|exists:shorts,id',
            'parent_id' => 'nullable|integer|exists:comments,id',
            'message' => 'required|string|max:250',
            'status' => 'nullable|boolean',
        ]);

        if($validate->fails()){
            $data['status'] = false;
            $data['message'] = "Invalid Inputs.";
            $data['errors'] = $validate->errors();
            return response()->json($data, 400);
        }

        $comment = new  Comment();
        $comment->user_id = $request->user_id;
        $comment->short_id = $request->short_id;
        $comment->parent_id = $request->parent_id ?? null;
        $comment->message =  $request->message;
        $comment->status =  $request->status ?? 1;

        try {
            $comment->save();
            $data['status'] = true;
            $data['message'] = "Comment stored successfully!";
            $data['comment'] = $comment;
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            $data['status'] = false;
            $data['message'] = "Comment store failed!";
            $data['errors'] = $th;
            return response()->json($data, 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit( $id)
    {
        $data['shot'] = Comment::find($id);
        return response()->json($data, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        $validate = Validator::make($request->all(),[
            'user_id' => 'required|integer|exists:users,id',
            'short_id' => 'required|integer|exists:shorts,id',
            'parent_id' => 'nullable|integer|exists:comments,id',
            'message' => 'required|string|max:250',
            'status' => 'nullable|boolean',
        ]);

        if($validate->fails()){
            $data['status'] = false;
            $data['message'] = "Invalid Inputs.";
            $data['errors'] = $validate->errors();
            return response()->json($data, 400);
        }

        $comment =   Comment::find($id);

        if($comment){
            $comment->user_id = $request->user_id;
            $comment->short_id = $request->short_id;
            $comment->parent_id = $request->parent_id ?? null;
            $comment->message =  $request->message;
            $comment->status =  $request->status ?? 1;
    
            try {
                $comment->save();
                $data['status'] = true;
                $data['message'] = "Comment stored successfully!";
                $data['comment'] = $comment;
                return response()->json($data, 200);
            } catch (\Throwable $th) {
                $data['status'] = false;
                $data['message'] = "Comment update failed!";
                $data['errors'] = $th;
                return response()->json($data, 500);
            }
        } else {
            $data['status'] = false;
            $data['message'] = "Comment update nothing found!";
            return response()->json($data, 404);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::find($id);
        if($comment){
            try {
                $comment->delete();
                $data['status'] = true;
                $data['message'] = "Comment deleted successfully!";
                return response()->json($data, 200);
            } catch (\Throwable $th) {
                $data['status'] = false;
                $data['message'] = "Failed to delete shot comment!";
                $data['errors'] = $th;
                return response()->json($data, 500);
            }
        } else {
            $data['status'] = false;
            $data['message'] = "Noting found to delete!";
            return response()->json($data, 404);
        }
    }
}
