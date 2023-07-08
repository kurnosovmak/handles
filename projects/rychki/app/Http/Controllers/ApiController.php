<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

abstract class ApiController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected const OK_CODE = 200;
    protected const OK_WITHOUT_ANSWER_CODE = 205;
    protected const ERROR_CODE = 400;
    protected const AUTH_ERROR_CODE = 403;
    protected const NOTFOUND_CODE = 404;

    protected function fail(string $message, int $statusCode = self::ERROR_CODE): JsonResponse
    {
        return (new JsonResponse())->setStatusCode($statusCode)->setData([
            'message' => $message,
        ]);
    }


    protected function successful(?array $data = [], ?string $message = null, int $statusCode = self::OK_CODE): JsonResponse
    {
        $data = ['data' => $data ?? [],];

        if ($message !== null) {
            $data['message'] = $message;
        }
        return (new JsonResponse())->setStatusCode($statusCode)->setData($data);
    }

}
