<?php

namespace Webdevcave\SimpleCache\Tests;

use PHPUnit\Framework\TestCase;
use ReflectionProperty;
use Webdevcave\SimpleCache\MemoryCache;

class MemoryCacheTest extends TestCase
{
    private ?MemoryCache $cache = null;

    public function testGet(): void
    {
        $this->assertNull($this->cache->get('foo'));

        $this->cache->set('foo', 'bar');
        $this->assertEquals('bar', $this->cache->get('foo'));
    }

    public function testHas(): void
    {
        $this->assertFalse($this->cache->has('foo'));

        $this->cache->set('foo', 'bar');
        $this->assertTrue($this->cache->has('foo'));
    }

    public function testGetMultiple(): void
    {
        //All undefined
        $getUndefined = $this->cache->getMultiple(['foo', 'bar']);
        $this->assertCount(2, $getUndefined);
        $this->assertNull($getUndefined['foo']);
        $this->assertNull($getUndefined['bar']);

        //Some defined
        $this->cache->set('foo', 'bar');
        $getPartialyDefined = $this->cache->getMultiple(['foo', 'bar']);
        $this->assertEquals('bar', $getPartialyDefined['foo']);
        $this->assertNull($getPartialyDefined['bar']);

        //All defined
        $this->cache->set('bar', 'foo');
        $getAllDefined = $this->cache->getMultiple(['foo', 'bar']);
        $this->assertEquals('bar', $getAllDefined['foo']);
        $this->assertEquals('foo', $getAllDefined['bar']);
    }

    public function testSet(): void
    {
        $this->assertFalse($this->cache->has('foo'));

        //Defgine value
        $this->cache->set('foo', 'bar');

        $this->assertTrue($this->cache->has('foo'));
        $this->assertEquals('bar', $this->cache->get('foo'));
    }

    public function testDelete(): void
    {
        $this->assertTrue($this->cache->set('foo', 'bar'));
        $this->assertTrue($this->cache->has('foo'));
        $this->assertEquals('bar', $this->cache->get('foo', null));
        $this->assertTrue($this->cache->delete('foo'));
        $this->assertFalse($this->cache->has('foo'));
    }

    public function testDeleteMultiple(): void
    {
        $this->cache->setMultiple([
            'foo' => 'bar',
            'bar' => 'foo',
        ]);

        $this->assertTrue($this->cache->has('foo'));
        $this->assertTrue($this->cache->has('bar'));
        $this->assertTrue($this->cache->deleteMultiple(['foo', 'bar']));
        $this->assertFalse($this->cache->has('foo'));
        $this->assertFalse($this->cache->has('bar'));
    }

    public function testClear(): void
    {
        $this->cache->setMultiple([
            'foo' => 'bar',
            'bar' => 'foo',
        ]);

        $ref = new ReflectionProperty($this->cache, 'cache');
        $this->assertCount(2, $ref->getValue($this->cache));
        $this->assertTrue($this->cache->clear());
        $this->assertEmpty($ref->getValue($this->cache));
    }

    public function testSetMultiple(): void
    {
        $this->cache->setMultiple([
            'foo' => 'bar',
            'bar' => 'foo',
        ]);

        $this->assertEquals('bar', $this->cache->get('foo'));
        $this->assertEquals('foo', $this->cache->get('bar'));

        $this->cache->setMultiple([
            'foo' => 'baz',
        ]);
        $this->assertEquals('baz', $this->cache->get('foo'));
    }

    protected function setUp(): void
    {
        $this->cache = new MemoryCache();
    }

    protected function tearDown(): void
    {
        $this->cache = null;
    }
}
