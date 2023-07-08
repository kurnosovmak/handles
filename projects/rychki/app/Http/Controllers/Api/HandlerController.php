<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\Handler\StoreHandlerRequest;
use Libs\Handler\Contracts\HandlerContract;
use Illuminate\Http\JsonResponse;

final class HandlerController extends ApiController
{
    public function __construct(
        private readonly HandlerContract $handle,
    )
    {
    }

    public function index(): JsonResponse
    {
        return $this->successful($this->handle->getAll());
    }


    public function store(StoreHandlerRequest $request): JsonResponse
    {
        $key = (string) $request->get('key');
        $value = (float) $request->get('value');

        if(!$this->handle->set($key, $value)){
            return $this->fail('Error');
        }

        return $this->successful(message: 'Key add');
    }


    public function show(string $key): JsonResponse
    {
        return $this->successful([
            $key => $this->handle->get($key),
        ]);
    }

    public function delete(string $key): JsonResponse
    {
        if(!$this->handle->delete($key)){
            return $this->fail('Error');
        }

        return $this->successful(message: 'Key delete');
    }
}
