<?php namespace WPKG;

use PHPUnit\Framework\TestCase;

class HostTest extends TestCase
{
    public $path = __DIR__ . '/../extra/tmp';

    public function test__construct()
    {
        try {
            $host = new Host();
            $this->assertTrue(is_object($host));
        } catch (\Exception $e) {
            $this->assertContains('Must be initialized ', $e->getMessage());
        }
    }

    public function testBuild()
    {
        $host = new Host();
        $host->name = 'test1';
        $host->profileId = 'profile1';
        $this->assertTrue(is_object($host->build()));
        $this->assertTrue(is_object($host->build(true)));

        $host = new Host();
        $host->name = 'test1';
        $host->profileId = ['profile1', 'profile2'];
        $this->assertTrue(is_object($host->build()));
    }
}
