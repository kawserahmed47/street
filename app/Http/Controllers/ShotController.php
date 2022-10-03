<?php

namespace App\Http\Controllers;

use App\Models\Shot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['shots'] = Shot::with('comments', 'reacts')->latest()->get();
        return response()->json($data, 200);
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
            'user_id' => 'required|string|max:150|exists:users,id',
            'media_url' => 'nullable',
            'title' => 'required|max:150',
            'description' => 'nullable|max:250',
            'content' => 'nullable',
            'view_type' => 'nullable',
            'status' => 'required|boolean',
        ]);

        if($validate->fails()){
            $data['status'] = false;
            $data['message'] = "Invalid Inputs.";
            $data['errors'] = $validate->errors();
            return response()->json($data, 400);
        }

        $shot = new  Shot();
        $shot->user_id = $request->user_id;
        $shot->media_url = $request->media_url;
        $shot->title = $request->title;
        $shot->description =  $request->description;
        $shot->content =  $request->content;
        $shot->view_type =  $request->view_type;
        $shot->status =  $request->status ?? 0;

        try {
            $shot->save();
            $data['status'] = true;
            $data['message'] = "Shot stored successfully!";
            $data['shot'] = $shot;
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            $data['status'] = false;
            $data['message'] = "Short store failed!";
            $data['errors'] = $th;
            return response()->json($data, 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shot  $shot
     * @return \Illuminate\Http\Response
     */
    public function show(Shot $shot)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Shot  $shot
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['shot'] = Shot::find($id);
        return response()->json($data, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shot  $shot
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(),[
            'user_id' => 'required|string|max:150|exists:users,id',
            'media_url' => 'nullable',
            'title' => 'required|max:150',
            'description' => 'nullable|max:250',
            'content' => 'nullable',
            'view_type' => 'nullable',
            'status' => 'required|boolean',
        ]);

        if($validate->fails()){
            $data['status'] = false;
            $data['message'] = "Invalid Inputs.";
            $data['errors'] = $validate->errors();
            return response()->json($data, 400);
        }

        $shot = Shot::find($id);

        if($shot) {
            $shot->user_id = $request->user_id;
            $shot->media_url = $request->media_url;
            $shot->title = $request->title;
            $shot->description =  $request->description;
            $shot->content =  $request->content;
            $shot->view_type =  $request->view_type;
            $shot->status =  $request->status ?? 0;
    
            try {
                $shot->save();
                $data['status'] = true;
                $data['message'] = "Shot stored successfully!";
                $data['shot'] = $shot;
                return response()->json($data, 200);
            } catch (\Throwable $th) {
                $data['status'] = false;
                $data['message'] = "Shot store failed!";
                $data['errors'] = $th;
                return response()->json($data, 500);
            }
        } else {
            $data['status'] = false;
            $data['message'] = "Nothing to update data!";
            return response()->json($data, 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shot  $shot
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $shot = Shot::find($id);
        if($shot){
            try {
                $shot->delete();
                $data['status'] = true;
                $data['message'] = "Shot deleted successfully!";
                return response()->json($data, 200);
            } catch (\Throwable $th) {
                $data['status'] = false;
                $data['message'] = "Failed to delete shot!";
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
