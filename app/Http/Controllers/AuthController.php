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
    public function __construct()
    {
        $this->middleware('jwt-auth:teacher,student')->only(['logout']);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            $token = JWTAuth::attempt($credentials);
            if (! $token) {
                //Aqui es la respuesta que se le da al cliente si se equivoca con sus contraseña o correo
                return $this->sendErrorResponse('Wrong credentials', 401);
                //Recuerden que si quieren enviar esta respuesta a moviles tiene que ser un SendErrorResponseForMobile pues el que tiene el codigo de error.
            }
        } catch (JWTException $e) {
            return $this->sendErrorResponse();
        }
        $user = Auth::user();
        return $this->sendSuccessLoginResponse([
            'token'=>$token,
            'role' => $user->id_role,
            'user' => $user->email,
            //Cambiar esto si el modelo del usuario no contiene un  profile picture.
            'profile_picture' => $user->profile_picture
        ], 'User successfully authenticated');
    }


    public function logout()
    {
        JWTAuth::invalidate();
        return $this->sendSuccessResponse(['user_unauthenticated'=>true],'Usuario Desautenticado');
    }
}
