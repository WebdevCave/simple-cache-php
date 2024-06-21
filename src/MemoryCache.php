<?php

namespace Webdevcave\SimpleCache;

use DateInterval;
use DateTime;
use Psr\SimpleCache\CacheInterface;
use Webdevcave\SimpleCache\Exceptions\InvalidArgumentException;

class MemoryCache implements CacheInterface
{
    private array $cache = [];

    /**
     * @inheritDoc
     */
    public function get(string $key, mixed $default = null): mixed
    {
        if (!$this->has($key)) {
            return $default;
        }

        return $this->cache[$key]['value'];
    }

    /**
     * @inheritDoc
     */
    public function set(string $key, mixed $value, DateInterval|int|null $ttl = null): bool
    {
        $expiration = null;

        if (!is_null($ttl)) {
            $expiration = new DateTime();

            if (is_int($ttl)) {
                if ($ttl < 0) {
                    throw new InvalidArgumentException('TTL must be a positive integer');
                }

                $ttl = new DateInterval("PT{$ttl}S");
            }

            $expiration->add($ttl);
        }

        $this->cache[$key] = compact('value', 'expiration');

        return true;
    }

    /**
     * @inheritDoc
     */
    public function delete(string $key): bool
    {
        if (!$this->has($key)) {
            return false;
        }

        unset($this->cache[$key]);

        return true;
    }

    /**
     * @inheritDoc
     */
    public function clear(): bool
    {
        $this->cache = [];

        return true;
    }

    /**
     * @inheritDoc
     */
    public function getMultiple(iterable $keys, mixed $default = null): iterable
    {
        $items = [];

        foreach ($keys as $key) {
            $items[$key] = $this->get($key, $default);
        }

        return $items;
    }

    /**
     * @inheritDoc
     */
    public function setMultiple(iterable $values, DateInterval|int|null $ttl = null): bool
    {
        foreach ($values as $key => $value) {
            $this->set($key, $value, $ttl);
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteMultiple(iterable $keys): bool
    {
        foreach ($keys as $key) {
            $this->delete($key);
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function has(string $key): bool
    {
        $this->deleteIfExpired($key);

        return isset($this->cache[$key]);
    }

    private function deleteIfExpired(string $key): void
    {
        if (!isset($this->cache[$key])) {
            return;
        }

        $item = $this->cache[$key];
        /* @var $expiration DateTime */
        $expiration = $item['expiration'];
        if (is_null($expiration)) {
            return;
        }

        if ($expiration < new DateTime()) {
            unset($this->cache[$key]);
        }
    }
}
