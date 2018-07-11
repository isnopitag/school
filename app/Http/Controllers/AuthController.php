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


    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password'=> 'required'
        ]);
        if ($validator->fails()) {
            return $this->getResponse(false,'Error al registrar',$validator->errors(),'',401);
        }
        $credentials = $request->only('email', 'password');
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return $this->getResponse(false,'Credenciales invalidas','','',401);
            }
        } catch (JWTException $e) {
            return $this->getResponse(false,'No se pudo crear el token','','',500);
        }
        return $this->getResponse(true,'Usuario Autenticado',compact('token'),'',200);
    }


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
