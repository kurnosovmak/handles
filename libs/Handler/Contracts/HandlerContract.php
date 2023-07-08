<?php

declare(strict_types=1);

namespace Libs\Handler\Contracts;

interface HandlerContract
{
    public function set(string $key, float $value): bool;

    public function get(string $key): ?float;

    public function delete(string $key): bool;

    /**
     * @return array<string, float>
     */
    public function getAll(): array;

    /**
     * @return array<int, string>
     */
    public function getAllKeys(): array;
}
