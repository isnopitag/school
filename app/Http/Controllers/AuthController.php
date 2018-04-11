<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use JWTFactory;
use JWTAuth;
use Validator;
use Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users',
            'name' => 'required',
            'password'=> 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
        ]);
        $user = User::first();
        $token = JWTAuth::fromUser($user);

        return Response::json(compact('token'));

    }



    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password'=> 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $credentials = $request->only('email', 'password');
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['token'=> null,'message' => 'invalid_credentials', 'status' => 'otra cosa', 'valid'=> 0], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['token'=> null,'message' => 'could_not_create_token' , 'status' => 'otra cosa', 'valid'=> 0], 500);
        }
        $message = 'success';
        $status = 'otra cosa pero Ok';
        $valid = 1;
        return response()->json(compact(['token','message','status','valid']));
    }



    public function logout()
    {
        JWTAuth::invalidate();
        return response([
            'status' => 'success',
            'message' => 'Logged out Successfully.'
        ], 200);
    }

    public function refresh()
    {
        return response([
            'status' => 'success'
        ]);
    }

    public function user(Request $request)
    {
        $user = User::find(Auth::user()->id);
        return response([
            'status' => 'success',
            'data' => $user
        ]);
    }

}
