<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    public function login(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if($validate->fails()){
            $data['status'] = false;
            $data['message'] = "Invalid Inputs.";
            $data['errors'] = $validate->errors();
            return response()->json($data, 400);
        }

        try {
            $credentials = $request->only('email', 'password');
            $token = Auth::attempt($credentials);
            if($token) {
                $user = Auth::user();
                $authorization['type'] = 'bearer';
                $authorization['token'] = $token;
                $data['status'] = true;
                $data['message'] = "Authorized";
                $data['user'] = $user;
                $data['authorization'] = $authorization;
                return response()->json($data, 200);
            } else {
                $data['status'] = false;
                $data['message'] = "Unauthorized";
                return response()->json($data, 401);
            }
        } catch (\Throwable $th) {
            $data['status'] = false;
            $data['message'] = "Something went wrong!";
            $data['errors'] = $th;
            return response()->json($data, 500);
        }
    }

    public function register(Request $request){
        
        $validate = Validator::make($request->all(),[
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20|unique:users',
            'name' => 'required|string|max:20',
            'password' => 'required|string|min:6',
        ]);

        if($validate->fails()){
            $data['status'] = false;
            $data['message'] = "Invalid Inputs.";
            $data['errors'] = $validate->errors();
            return response()->json($data, 400);
        }

        
        try {
            $user = User::create([
                'role_id' => 3,
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
            ]);
    
            $token = Auth::login($user);

            $authorization['type'] = 'bearer';
            $authorization['token'] = $token;
            $data['status'] = true;
            $data['message'] = 'User created successfully';
            $data['user'] = $user;
            $data['authorization'] = $authorization;
            return response()->json($data, 200);

        } catch (\Throwable $th) {
            $data['status'] = false;
            $data['message'] = "Something went wrong!";
            $data['errors'] = $th;
            return response()->json($data, 500);
        }
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorization' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }



}
