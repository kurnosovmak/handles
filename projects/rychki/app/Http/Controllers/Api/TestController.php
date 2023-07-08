<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Libs\Handler\Service\HandlerHelper;
use Illuminate\Http\JsonResponse;

final class TestController extends ApiController
{
    public function __construct(
        private readonly HandlerHelper $handlerHelper,
    )
    {
    }

    public function test(): JsonResponse
    {
        return $this->successful([
            $this->handlerHelper->partEnable('test') ? 'старый' : 'новый'
        ]);
    }
}
