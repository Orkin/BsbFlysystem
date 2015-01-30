<?php

namespace BsbFlysystemTest\Cache;

use BsbFlysystem\Cache\ZendStorageCache;
use BsbFlysystemTest\Framework\TestCase;

/**
 * Tests for the zend cache wrapper
 */
class ZendStorageCacheTest extends TestCase
{

    public function testLoadDefault()
    {
        $mock = $this->getMock('Zend\Cache\Storage\StorageInterface');
        $mock->expects($this->once())->method('getItem');

        $zendStorageCache = new ZendStorageCache($mock);
        $zendStorageCache->load();
    }

    public function testLoadDefaultCallsSetFromStorage()
    {
        $mock = $this->getMock('Zend\Cache\Storage\StorageInterface');
        // setFromStorage expects json in this form
        $mock->expects($this->once())->method('getItem')->willReturn('this-is-not-valid-json');

        $zendStorageCache = new ZendStorageCache($mock);
        $zendStorageCache->load();

        $this->assertTrue(json_last_error() !== JSON_ERROR_NONE);
    }

    public function testLoadWithCustomKey()
    {
        $mock = $this->getMock('Zend\Cache\Storage\StorageInterface');
        $mock->expects($this->once())->method('getItem')->with('akey');
        $zendStorageCache = new ZendStorageCache($mock, 'akey');

        $zendStorageCache->load();
    }

    public function testSaveDefault()
    {
        $mock = $this->getMock('Zend\Cache\Storage\StorageInterface');
        $mock->expects($this->once())->method('setItem');

        $zendStorageCache = new ZendStorageCache($mock);
        $zendStorageCache->save();
    }

    public function testSaveWithCustomKey()
    {
        $mock = $this->getMock('Zend\Cache\Storage\StorageInterface');
        $mock->expects($this->once())->method('setItem')->with('akey');

        $zendStorageCache = new ZendStorageCache($mock, 'akey');
        $zendStorageCache->save();
    }
}
