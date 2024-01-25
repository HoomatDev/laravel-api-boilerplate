<?php

namespace Hoomat\Base\App\Http\Controllers;

use Hoomat\Base\App\Http\Resources\PaginationResource;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Collection;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;


    /**
     * Send an Array of Items as SuccessResponse
     *
     * @param mixed  $data
     * @param mixed  $resourceClass
     * @param string $msg
     * @return JsonResponse
     */
    public function dynamicResponse(
        mixed $data, mixed $resourceClass, string $msg = 'success'
    ): JsonResponse
    {
        $resData = ['item' => $resourceClass::collection($data)];
        if ($data instanceof LengthAwarePaginator) {
            $resData = [
                'items' => $resourceClass::collection($data->items()),
                'links' => PaginationResource::make($data)
            ];
        } else if ($data instanceof Collection || is_array($data)) {
            $resData = ['items' => $resourceClass::collection($data)];
        }

        return $this->successResponse($resData, $msg);
    }


    /**
     * Send a SuccessResponse
     *
     * @param mixed   $data
     * @param string  $msg
     * @return JsonResponse
     */
    public function successResponse(mixed $data = [], string $msg = 'success'): JsonResponse
    {
        return response()->json([
            'error' => false,
            'message' => $msg,
            'data' => $data
        ], 200);
    }


    /**
     * Send an ErrorResponse
     *
     * @param mixed  $data
     * @param int    $statusCode
     * @param string $msg
     * @return JsonResponse
     */
    public function errorResponse(mixed $data, int $statusCode = 500, string $msg = 'error'): JsonResponse
    {
        return response()->json([
            'error' => true,
            'message' => $msg,
            'data' => $data
        ], $statusCode);
    }
}
