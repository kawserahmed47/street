<?php

namespace App\Http\Controllers;

use App\Models\React;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReactController extends Controller
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
            'react' => 'required|string|max:150',
        ]);

        if($validate->fails()){
            $data['status'] = false;
            $data['message'] = "Invalid Inputs.";
            $data['errors'] = $validate->errors();
            return response()->json($data, 400);
        }

        $react = new  React();
        $react->user_id = $request->user_id;
        $react->short_id = $request->short_id;
        $react->react = $request->react;

        try {
            $react->save();
            $data['status'] = true;
            $data['message'] = "React stored successfully!";
            $data['react'] = $react;
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            $data['status'] = false;
            $data['message'] = "React store failed!";
            $data['errors'] = $th;
            return response()->json($data, 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\React  $react
     * @return \Illuminate\Http\Response
     */
    public function show(React $react)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\React  $react
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['react'] = React::find($id);
        return response()->json($data, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\React  $react
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        $validate = Validator::make($request->all(),[
            'user_id' => 'required|integer|exists:users,id',
            'short_id' => 'required|integer|exists:shorts,id',
            'react' => 'required|string|max:150',
        ]);

        if($validate->fails()){
            $data['status'] = false;
            $data['message'] = "Invalid Inputs.";
            $data['errors'] = $validate->errors();
            return response()->json($data, 400);
        }

        $react =   React::find($id);

        if ($react) {
            $react->user_id = $request->user_id;
            $react->short_id = $request->short_id;
            $react->react = $request->react;

            try {
                $react->save();
                $data['status'] = true;
                $data['message'] = "React updated successfully!";
                $data['react'] = $react;
                return response()->json($data, 200);
            } catch (\Throwable $th) {
                $data['status'] = false;
                $data['message'] = "React update failed!";
                $data['errors'] = $th;
                return response()->json($data, 500);
            }
        } else {
            $data['status'] = false;
            $data['message'] = "React update failed!";
            return response()->json($data, 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\React  $react
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        $short = React::find($id);
        if($short){
            try {
                $short->delete();
                $data['status'] = true;
                $data['message'] = "Short react deleted successfully!";
                return response()->json($data, 200);
            } catch (\Throwable $th) {
                $data['status'] = false;
                $data['message'] = "Failed to delete short react!";
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
