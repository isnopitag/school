<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\User;
use JWTFactory;
use JWTAuth;
use Validator;
use Response;

class AuthController extends ApiController
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            $token = JWTAuth::attempt($credentials);
            if (! $token) {
                return $this->sendErrorResponse('Wrong credentials', 401);
            }
        } catch (JWTException $e) {
            return $this->sendErrorResponse();
        }
        $user = Auth::user();
        return $this->sendSuccessResponse([
            'token'=>$token,
            'user' => $user->email,
            'profile_picture' => $user->profile_picture
        ], 'User successfully authenticated');
    }


    //TODO Uncomment if you need it, delete it if the project doesn't need it
    /*
    public function register(RegisterRequest $request){
        $file = $request->file('profile_picture');
        $path = $file ? $file->store('public') : 'public/no_image.png';
        $user = User::create([
            'email' => $request->email,
            'username' => $request->username,
            'name' => $request->name,
            'profile_picture' => $path,
            'rfc' => $request->rfc,
            'password' => $request->password,
            'birth' => $request->birth,
            'sex' => $request->sex,
            'mobile_phone' => $request->mobile_phone,
            'address' => $request->address,
            'id_role' => $request->id_role
        ]);
        return $this->sendSuccessResponse($user, 'User successfully registered');
    }

    */
    public function logout()
    {
        JWTAuth::invalidate();
        return $this->getResponse(true,'Usuario Desautenticado','','',200);
    }

    public function refresh()
    {
        JWTAuth::refresh();
        return $this->getResponse(true,'Token Refrescado',compact('token'),'',200);
    }

    public function user(Request $request)
    {
        $user = User::find(Auth::user()->id);
        return $this->getResponse(true,'Usuario',$user,'',200);
    }

    private function getResponse($flag,$message,$data,$meta,$status){
        return response()->json(['flag'=>$flag,
            'message'=>$message,
            'data'=>[$data],
            'meta'=>[$meta]], $status);
    }

}
