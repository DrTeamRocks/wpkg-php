<?php namespace WPKG\Classes\Packages;

use PHPUnit\Framework\TestCase;

class PackageTest extends TestCase
{
    public function test__construct()
    {
        try {
            $package = new Package();
            $this->assertTrue(is_object($package));
        } catch (\Exception $e) {
            $this->assertContains('Must be initialized ', $e->getMessage());
        }
    }

    public function testSetGetVariable()
    {
        $package = new Package();
        $package->setVariable('test', 'value');
        $this->assertTrue(is_array($package->getVariables()));
        $this->assertEquals(count($package->getVariables()), 1);
        $this->assertEquals($package->getVariables('test'), 'value');
    }

    public function testSetGetCommand()
    {
        $package = new Package();
        $package->setCommand('install', 'ping 8.8.8.8');
        $package->setCommand('install', 'test', 'include');
        $package->setCommand('update', 'test2', ['test1', 'test2']);
        $package->setCommand('update', 'test', 'include', [0, 3010 => true, 'any', 2]);
        $package->setCommand('uninstall', 'bb');

        $this->assertTrue(is_array($package->getCommands()));
        $this->assertEquals(count($package->getCommands()), 3);
        $this->assertEquals(count($package->getCommands('install')), 2);
        $this->assertEquals($package->getCommands('install')[0]['cmd'], 'ping 8.8.8.8');
    }

    public function testSetGetCheck()
    {
        $package = new Package();
        $package->setCheck('install', 'a+b', 'c');
        $package->setCheck('install', 'a+ab', 'ac');
        $package->setCheck('update', 'a+c', 'b');
        $package->setCheck('uninstall', 'a-b', 'z');

        $this->assertTrue(is_array($package->getChecks()));
        $this->assertEquals(count($package->getChecks()), 3);
        $this->assertEquals(count($package->getChecks('install')), 2);
        $this->assertEquals($package->getChecks('update')[0]['path'], 'b');
    }

    public function testBuild()
    {
        $package = new Package();
        $package->id = 'test1';
        $package->name = 'extra package';
        $package->revision = '2';
        $package->reboot = 'yep';
        $package->priority = '999';
        $package->execute = 'sometimes';

        $this->assertTrue(is_object($package->build()));
        $this->assertTrue(is_object($package->build(true)));
    }
}
