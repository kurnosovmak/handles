<?php

declare(strict_types=1);

namespace Libs\Handler\Service;

use Libs\Handler\Contracts\HandlerContract;
use Psr\Log\LoggerInterface;

final class HandlerService
{
    public function __construct(
        private readonly HandlerContract $handleContract,
        private readonly LoggerInterface $logger,
    )
    {
    }

    public function get(string $key): float
    {
        $handle = $this->handleContract->get($this->getHandleNameWithoutPrefix($key));

        if ($handle === null) {
            return $this->getDefaultValueByPrefix($key);
        }

        return $handle;
    }

    public function set(string $key, float $value): void
    {
        if (!$this->validateValue($value)) {
            $this->logger->error('Attempt to set a value for a key not in the range from 0 to 1.', [
                'key' => $key,
                'value' => $value,
            ]);
            return;
        }
        $isSet = $this->handleContract->set($this->getHandleNameWithoutPrefix($key), $value);

        if (!$isSet) {
            $this->logger->error('Failed to save value.', [
                'key' => $key,
                'value' => $value,
            ]);
            return;
        }
    }

    public function delete(string $key): void
    {

    }

    private function validateValue(float $value, float $min = 0, float $max = 1): bool
    {
        return $min <= $value && $value <= $max;
    }

    private function getHandleNameWithoutPrefix(string $key): string
    {
        return $key;
    }

    private function getDefaultValueByPrefix(string $key): float
    {
        return 0;
    }
}
