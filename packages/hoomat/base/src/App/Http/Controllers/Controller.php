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
     * @param        $collection
     * @param string $msg
     * @return JsonResponse
     */
    public function paginatedResponse(mixed $data, $collection, string $msg = 'success'): JsonResponse
    {
        if ($data instanceof LengthAwarePaginator) {
            $pagination = PaginationResource::make($data);
        }

        return $this->successResponse($collection, $msg, $pagination ?? null);
    }


    /**
     * Send a SuccessResponse
     *
     * @param mixed  $data
     * @param string $msg
     * @param null   $pagination
     * @return JsonResponse
     */
    public function successResponse(mixed $data = [], string $msg = 'success', $pagination = null): JsonResponse
    {
        return response()->json([
            'error' => false,
            'message' => $msg,
            'data' => $data,
            'links' => $pagination
        ]);
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
