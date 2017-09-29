<?php namespace WPKG;

use PHPUnit\Framework\TestCase;

class HostsTest extends TestCase
{
    public $path = __DIR__ . '/../extra/tmp';

    public function testConstruct()
    {
        try {
            $hosts = new Hosts();
            $this->assertTrue(is_object($hosts));
        } catch (\Exception $e) {
            $this->assertContains('Must be initialized ', $e->getMessage());
        }
    }

    public function testAdd()
    {
        $hosts = new Hosts();
        $this->assertTrue(is_object($hosts->add('test1', 'profile1')));
    }

    public function testGet()
    {
        $hosts = new Hosts();
        $hosts->add('test1', 'profile1');
        $this->assertTrue(is_string($hosts->get('test1')));
        $this->assertEquals('profile1', $hosts->get('test1'));

        $hosts->add('test2', ['one', 'two', 'three']);
        $this->assertTrue(is_array($hosts->get('test2')));
        $this->assertEquals(['one', 'two', 'three'], $hosts->get('test2'));

        $this->assertTrue(is_array($hosts->get()));
        $this->assertEquals(2, count($hosts->get()));
    }

    public function testBuild()
    {
        $hosts = new Hosts();
        $hosts->add('test1', 'profile1');
        $this->assertTrue(is_object($hosts->build()));
    }

}
