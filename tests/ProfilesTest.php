<?php namespace WPKG;

use PHPUnit\Framework\TestCase;

class ProfilesTest extends TestCase
{
    public $path = __DIR__ . '/../extra/tmp';

    public function testConstruct()
    {
        try {
            $profiles = new Profiles();
            $this->assertTrue(is_object($profiles));
        } catch (\Exception $e) {
            $this->assertContains('Must be initialized ', $e->getMessage());
        }
    }

    public function testAdd()
    {
        $profiles = new Profiles();
        $this->assertTrue(is_object($profiles->set('profile0')));
        $this->assertTrue(is_object($profiles->set('profile1', 'DotNet')));
        $this->assertTrue(is_object($profiles->set('profile2', ['Firefox', 'Chromium', 'Opera'], 'profile1')));
        $this->assertTrue(is_object($profiles->set('profile3', ['SuperBank', 'AnotherBank'], ['profile1', 'profile2'])));
        $this->assertTrue(is_object($profiles->set('profile4', null, 'profile3')));
    }

    public function testGet()
    {
        $profiles = new Profiles();
        $profiles->set('profile0');
        $this->assertTrue(is_array($profiles->get('profile0')));
        $this->assertEquals([], $profiles->get('profile0'));

        $profiles->set('profile1', 'DotNet');
        $this->assertTrue(is_array($profiles->get('profile1')));
        $this->assertEquals(['packages' => 'DotNet'], $profiles->get('profile1'));

        $profiles->set('profile2', null, 'profile1');
        $this->assertTrue(is_array($profiles->get('profile2')));
        $this->assertEquals(['depends' => 'profile1'], $profiles->get('profile2'));

        $this->assertTrue(is_array($profiles->get()));
        $this->assertEquals(3, count($profiles->get()));
    }

    public function testBuild()
    {
        $profiles = new Profiles();
        $profiles->set('profile0');
        $this->assertTrue(is_object($profiles->build()));
    }

}
