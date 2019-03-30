<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use League\Fractal;

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
        ], 200);
    }

    protected function sendErrorResponse($message = 'Unexpected error. Try again.', $code=501){
        return response()->json([
            'flag'=>false,
            'message'=>$message],
        $code);
    }
}