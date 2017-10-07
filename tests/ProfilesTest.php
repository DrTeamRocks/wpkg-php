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

        $p0 = new Profile();
        $p0->id = 'profile0';
        $this->assertTrue(is_object($profiles->set($p0)));

        $p1 = new Profile();
        $p1->id = 'profile1';
        $p1->packages = 'DotNet';
        $this->assertTrue(is_object($profiles->set($p1)));

        $p2 = new Profile();
        $p2->id = 'package2';
        $p2->packages = ['Firefox', 'Chromium', 'Opera'];
        $p2->depends = 'profile1';
        $this->assertTrue(is_object($profiles->set($p2)));

        $p3 = new Profile();
        $p3->id = 'package3';
        $p3->packages = ['SuperBank', 'AnotherBank'];
        $p3->depends = ['profile1', 'profile2'];
        $this->assertTrue(is_object($profiles->set($p3)));

        $p4 = new Profile();
        $p4->id = 'package4';
        $p4->depends = 'profile3';
        $this->assertTrue(is_object($profiles->set($p4)));
    }

    public function testGet()
    {
        $profiles = new Profiles();

        $p0 = new Profile();
        $p0->id = 'profile0';
        $profiles->set($p0);
        $this->assertTrue(is_object($profiles->get('profile0')));

        $p1 = new Profile();
        $p1->id = 'profile1';
        $p1->packages = 'DotNet';
        $profiles->set($p1);
        $this->assertTrue(is_object($profiles->get('profile1')));
        $this->assertEquals('DotNet', $profiles->get('profile1')->packages);

        $p2 = new Profile();
        $p2->id = 'profile2';
        $p2->packages = ['Firefox', 'Chromium', 'Opera'];
        $p2->depends = 'profile1';
        $profiles->set($p2);
        $this->assertTrue(is_object($profiles->get('profile2')));
        $this->assertEquals('profile1', $profiles->get('profile2')->depends);

        $this->assertTrue(is_array($profiles->get()));
        $this->assertEquals(3, count($profiles->get()));
    }

    public function testBuild()
    {
        $profiles = new Profiles();
        $p0 = new Profile();
        $p0->id = 'profile0';
        $profiles->set($p0);
        $this->assertTrue(is_object($profiles->build()));
    }

}
