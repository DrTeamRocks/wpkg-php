<?php namespace WPKG\Classes\Hosts;

use PHPUnit\Framework\TestCase;

class HostsTest extends TestCase
{
    public $path = __DIR__ . '/../extra/tmp';

    public function test__construct()
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

        $host = new Host();
        $host->name = 'test1';
        $host->profileId = 'profile1';

        $this->assertTrue(is_object($hosts->set($host)));
    }

    public function testGet()
    {
        $hosts = new Hosts();

        $h1 = new Host();
        $h1->name = 'test1';
        $h1->profileId = 'profile1';

        $hosts->set($h1);
        $this->assertTrue(is_object($hosts->get('test1')));
        $this->assertEquals('profile1', $hosts->get('test1')->profileId);

        $h2 = new Host();
        $h2->name = 'test2';
        $h2->profileId = ['one', 'two', 'three'];

        $hosts->set($h2);
        $this->assertTrue(is_object($hosts->get('test2')));
        $this->assertEquals(['one', 'two', 'three'], $hosts->get('test2')->profileId);

        $this->assertTrue(is_array($hosts->get()));
        $this->assertEquals(2, count($hosts->get()));
    }

    public function testBuild()
    {
        $hosts = new Hosts();

        $host = new Host();
        $host->name = 'test1';
        $host->profileId = 'profile1';

        $hosts->set($host);
        $this->assertTrue(is_object($hosts->build()));
    }

}
