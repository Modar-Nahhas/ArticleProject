<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public static function getJsonResponse(string $message, $data = null, bool $result = true, int $code = 200, $exception = null): JsonResponse
    {
        $result = [
            'message' => $message,
            'result' => $result,
            'code' => $code

        ];
        if (isset($data)) {
            $result['data'] = $data;
        }
        if (isset($exception)) {
            $result['exception'] = $exception;
        }
        return response()->json($result, $code);
    }
}
