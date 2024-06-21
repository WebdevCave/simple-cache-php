<?php

namespace Webdevcave\SimpleCache;

use DateInterval;
use Psr\SimpleCache\CacheInterface;

class VoidCache implements CacheInterface
{
    /**
     * @inheritDoc
     */
    public function get(string $key, mixed $default = null): mixed
    {
        return $default;
    }

    /**
     * @inheritDoc
     */
    public function set(string $key, mixed $value, DateInterval|int|null $ttl = null): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function delete(string $key): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function clear(): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function getMultiple(iterable $keys, mixed $default = null): iterable
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function setMultiple(iterable $values, DateInterval|int|null $ttl = null): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteMultiple(iterable $keys): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function has(string $key): bool
    {
        return false;
    }
}
