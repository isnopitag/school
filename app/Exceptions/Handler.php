<?php

namespace App\Exceptions;

use Exception;

use Illuminate\Auth\AuthenticationException;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof UnauthorizedHttpException) {
            return response()->json(
                ['flag' => false ,'message'=>'status: token_unauthorized'], $exception->getStatusCode()
            );
        } else if ($exception->getPrevious() instanceof TokenExpiredException) {
            return response()->json(
                ['flag' => false,'message'=>'status: token_expired'],$exception->getStatusCode()
            );
        } else if ($exception->getPrevious() instanceof TokenInvalidException) {
            return response()->json(
                ['status' => 'token_invalid'], $exception->getStatusCode()
            );
        } else if ($exception->getPrevious() instanceof TokenBlacklistedException) {
            return response()->json(
                ['status' => 'token_blacklisted'], $exception->getStatusCode()
            );
        } else if ($exception instanceof ModelNotFoundException) {
            return response()->json(
                //TODO Si el proyecto es enfocado a un sistema web dejar esta linea
                [ 'flag' => false,'message' => 'El elemento de tipo: '.substr($exception->getModel(),4).', no se encontro' , 'data' => [], 'meta' =>[]], 404
                //TODO Si el sistema contiene app y sistema descomentar esta linea
                //TODO Justificacion: porque agrega un code, codigo de error, que cuando el metodo firstOrFail falla cae aqui a este Handler
            //[ 'flag' => false,'code' => 1000,'message' => 'El elemento de tipo: '.substr($exception->getModel(),4).', no se encontro' , 'data' => [], 'meta' =>[]], 404
            );
        }
        return parent::render($request, $exception);
    }


    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.']);
        }
        return response()->json(['error' => 'Unauthenticated.']);
        //return redirect()->guest('home');
    }
}
