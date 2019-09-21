<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use League\Fractal;
use JWTAuth;
class ApiController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private function createFractal($include=[])
    {
        $fractal = new Fractal\Manager();
        $fractal->setSerializer(new Fractal\Serializer\ArraySerializer());
        $fractal->parseIncludes($include);

        return $fractal;
    }

    public function createCollectionData($results, $transformer, $include=[], $paginator=null)
    {
        $fractal = $this->createFractal($include);
        $resource = new Fractal\Resource\Collection($results, $transformer);
        if($paginator){
            $resource->setPaginator(new Fractal\Pagination\IlluminatePaginatorAdapter($paginator));
        }
        $results = $fractal->createData($resource)->toArray();

        return $results;
    }

    public function createItemData($results, $transformer, $include=[])
    {
        $fractal = $this->createFractal($include);
        $resource = new Fractal\Resource\Item($results, $transformer);
        $results = $fractal->createData($resource)->toArray();

        return $results;
    }

    protected function sendNotFoundResponse($resourceName = 'Resource'){
        return response()->json([
            'flag'=>false,
            'message' => $resourceName.' not found'
        ], 404);
    }

    protected function sendSuccessResponse($data, $message = 'Successful operation', $meta = []){
        return response()->json([
            'flag' => true,
            'message' => $message,
            'data' => $data,
            'meta' => $meta
        ], 200,[],JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
        //TODO: Si despues del 200 va un array[] vacio es parte del metodo.
    }

    protected function sendErrorResponse($message = 'Unexpected error. Try again.', $code=501){
        return response()->json([
            'flag'=>false,
            'message'=>$message],
        $code);
    }

    /**
     * Este metodo es una vaiante del SendSucces Response
     *
     * Este metodo agrega la cookie (token) a la respuesta
     * con el valor del  token para el usuario autenticada
     *
     * @param array  $data    Data array with minimal information
     *                        of the authenticated user
     * @param string $message Custom message indicating the status
     *                        of the user login. 'Successful operation'
     *                        is set by default
     * @param array  $meta    Array of metadata with instructions to
     *                        manipulate the resource data
     *
     * @return void
     */

    //TODO: Este metodo es importante porque es el que agrega la cookie a donde este respondiendo
    protected function sendSuccessLoginResponse($data, $message = 'Successful operation', $meta = [])
    {
        $token = $data['token'];
        unset($data['token']);
        return response()
            ->json(
                [
                    'flag' => true,
                    'message' => $message,
                    'data' => $data,
                    'meta' => $meta
                ], 200,[], JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT
            )
            ->header(
                'Content-type', 'text/json'
            )
            ->cookie('token', $token, 60);
        //Ese options al final son filtros para que la respuesta quede con un formato agradable
    }

    protected function getAuthenticatedUser(){
        $user= null;
        try{
            $user = JWTAuth::user();
        }
        catch (Exceptions\JWTException $e){
            $this->sendErrorResponse('Sessión invalida here', 403);
        }
        return $user;
    }

    protected function sendErrorResponseForMobile($errorCode = 0000,$message = 'Error inesperado, inténtelo de nuevo', $code=501){
        return response()->json([
            'flag'=>false,
            'code' => $errorCode,
            'message'=>$message],
            $code);
    }

    protected function sendCollectionCorrectResponse($query,$model,$code=404){
        if($query->isEmpty()){
            return $this->sendErrorResponse('No hay registros de '.$model,$code);
        }
        return $this->sendSuccessResponse($query,'Todos los '.$model.' cargados');
    }

    public function sendToOneDevice($title = 'Notificación de ivm',$message = 'Comprobar applicación', $token){

        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);
        $priority = 'high';
        $optionBuilder->setPriority($priority);

        $notificationBuilder = new PayloadNotificationBuilder($title);
        $notificationBuilder->setBody($message)
            ->setSound('default');

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(['title' => $title, 'message' => $message ]);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();

        $data = $dataBuilder->build();

        FCM::sendTo($token, $option, $notification, $data);

        return true;
    }

    public function sendToMultipleDevices( $title = 'Notificación de ivm',$message = 'Comprobar applicación', $tokens){
        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);
        $priority = 'high';
        $optionBuilder->setPriority($priority);

        $notificationBuilder = new PayloadNotificationBuilder($title);
        $notificationBuilder->setBody($message)
            ->setSound('default');

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(['a_data' => 'my_data']);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();


        $downstreamResponse = FCM::sendTo($tokens, $option, $notification, $data);

        $downstreamResponse->numberSuccess();
        $downstreamResponse->numberFailure();
        $downstreamResponse->numberModification();
        return true;
    }
}