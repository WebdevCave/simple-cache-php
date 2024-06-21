<?php

namespace Webdevcave\SimpleCache\Tests;

use Webdevcave\SimpleCache\VoidCache;
use PHPUnit\Framework\TestCase;

class VoidCacheTest extends TestCase
{
    private ?VoidCache $cache = null;

    public function testSet()
    {
        $this->cache->set('foo', 'bar');

        $this->assertFalse($this->cache->has('foo'));
    }

    public function testDelete()
    {
        $this->assertTrue($this->cache->delete('foo'));
    }

    public function testGet()
    {
        $this->cache->set('foo', 'bar');

        $this->assertNull($this->cache->get('foo', null));
    }

    public function testGetMultiple()
    {
        $this->assertEmpty($this->cache->getMultiple(['foo', 'bar']));
    }

    public function testSetMultiple()
    {
        $this->assertTrue($this->cache->setMultiple(['foo' => 'bar']));
    }

    public function testHas()
    {
        //Hasn't a foo key
        $this->assertFalse($this->cache->has('foo'));

        //Continue not having, since it is a void cache
        $this->cache->set('foo', 'bar');
        $this->assertFalse($this->cache->has('foo'));
    }

    public function testDeleteMultiple()
    {
        $this->assertTrue($this->cache->deleteMultiple(['foo', 'bar']));
    }

    public function testClear()
    {
        $this->assertTrue($this->cache->clear());
    }

    protected function setUp(): void
    {
        $this->cache = new VoidCache();
    }

    protected function tearDown(): void
    {
        $this->cache = null;
    }
}
