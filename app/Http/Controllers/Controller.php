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
    const API_VERSION = '18.09.2023';
    const CODE_SUCCESS = 200;
    const CODE_ERROR = 201;
    const SERVER = 202;
    public function responseData($data, int $statusCode = 200, string $code = self::CODE_SUCCESS, array $messages = []): JsonResponse
    {
        $dataFormat = [
            'version' => self::API_VERSION,
            'status' => [
                'code' => $code,
                'message' => $messages,
                'api' => request()->path()
            ],
            'result' => $data,
        ];        
        return response()->json($dataFormat, $statusCode);
    }
}
