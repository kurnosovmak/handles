<?php

declare(strict_types=1);

namespace Libs\Handler\Repositories;

use Libs\Handler\Contracts\HandlerContract;
use Psr\Log\LoggerInterface;
use Illuminate\Support\Facades\Redis;
use RedisException;

final class RedisRepository implements HandlerContract
{

    public const PREFIX = 'CFG_';

    public function __construct(
        private readonly LoggerInterface $logger,
    )
    {
    }

    public function set(string $key, float $value, int $timeout = 1000): bool
    {
        try {
            Redis::set($this->getRegisKeyName($key), (string)$value, $timeout);
        } catch (RedisException $exception) {
            $this->logger->error('Redis not work', [
                'exception' => $exception,
                'key' => $key,
                'redis_key' => $this->getRegisKeyName($key),
                'value' => (string)$value,
            ]);

            return false;
        }

        return true;
    }

    public function get(string $key): ?float
    {
        try {
            $value = Redis::get($this->getRegisKeyName($key));
        } catch (RedisException $exception) {
            $this->logger->error('Redis not work', [
                'exception' => $exception,
            ]);

            return null;
        }
        if ($value === null) {
            return null;
        }

        return (float)$value;
    }

    public function delete(string $key): bool
    {
        try {
            Redis::del($this->getRegisKeyName($key));
        } catch (RedisException $exception) {
            $this->logger->error('Redis not work', [
                'exception' => $exception,
            ]);

            return false;
        }

        return true;
    }

    /**
     * @return array<string, float>
     */
    public function getAll(): array
    {
        $keys = $this->getAllKeys();

        try {
            $kv = [];
            foreach ($keys as $key) {
                $clearLey = substr($key, strlen(self::PREFIX));
                $kv[$clearLey] = $this->get($clearLey);
            }
        } catch (RedisException $exception) {
            $this->logger->error('Redis not work', [
                'exception' => $exception,
            ]);
            return [];
        }

        return $kv;
    }

    /**
     * @return string[]
     */
    public function getAllKeys(): array
    {
        try {
            $keys = Redis::keys(self::PREFIX . '*');
        } catch (RedisException $exception) {
            $this->logger->error('Redis not work', [
                'exception' => $exception,
            ]);
            return [];
        }

        return $keys;
    }

    private function getRegisKeyName(string $originKey): string
    {
        return self::PREFIX . $originKey;
    }
}
