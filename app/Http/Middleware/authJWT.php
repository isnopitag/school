<?php
/**
 * Created by PhpStorm.
 * User: carmona
 * Date: 21/03/18
 * Time: 03:25 PM
 */
namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Exceptions;

class authJWT
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        //TODO: Este metodo recibe una dispersion de los roles aqui es donde pasan la seguridad de JWT
        $user = null;
        try {
            $user = JWTAuth::parseToken()->authenticate();
            //$user =JWTAuth::parseToken()->toUser();
        } catch(Exceptions\TokenInvalidException $e) {
            return response()->json(
                [
                    'flag' => false,
                    'message'=>'Token is Invalid',
                    'data' =>[],
                    'meta' => []
                ], $e->getStatusCode()
            );
        } catch(Exceptions\TokenExpiredException $e){
            return response()->json(
                [
                    'flag' => false,
                    'message'=>'Token is Expired',
                    'data' =>[],
                    'meta' => []
                ], 401//, $e->getStatusCode()
            );
        }catch (Exceptions\JWTException $e){
            //TODO: este metodo esta en español porque aqui es donde entra en caso de que no se tenga una session valida
            return response()->json(
                [
                    'flag' => false,
                    'message'=>'No hay token para esta session',
                    'data' =>[],
                    'meta' => []
                ], 401
            );
        } catch (Exception $e) {
            return response()->json(
                [
                    'flag' => false,
                    'message'=>'Unknown error',
                    'data' =>[],
                    'meta' => []
                ], 501
            );
        }

        if(!$roles || $user->inRoles(...$roles))
            return $next($request);
            //TODO aqui es donde determina si tiene acceso o no las seecciones
        return response()->json(
            [
                'flag' => false,
                'message'=>'El usuario no tiene permisos de acceder a esta seccion.',
                'data' =>[],
                'meta' => []
            ], 403
        );
    }
}