<?php

declare(strict_types=1);

namespace Libs\Handler\Service;


final class HandlerHelper
{
    public function __construct(
        private readonly HandlerService $handlerService,
    )
    {
    }

    public function featureEnable(string $key): bool
    {
        return $this->handlerService->get($key) != 0;
    }

    public function featureDisable(string $key): bool
    {
        return $this->handlerService->get($key) == 0;
    }

    public function partEnable(string $key): bool
    {
        $value = $this->handlerService->get($key);

        return rand(0, 100) > (int)($value * 100);
    }

    public function partDisable(string $key): bool
    {
        $value = $this->handlerService->get($key);

        return rand(0, 100) < (int)($value * 100);
    }
}
