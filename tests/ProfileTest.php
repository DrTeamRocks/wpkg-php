<?php namespace WPKG;

use PHPUnit\Framework\TestCase;

class ProfileTest extends TestCase
{
    public $path = __DIR__ . '/../extra/tmp';

    public function test__construct()
    {
        try {
            $profile = new Profile();
            $this->assertTrue(is_object($profile));
        } catch (\Exception $e) {
            $this->assertContains('Must be initialized ', $e->getMessage());
        }
    }

    public function testBuild()
    {
        $pr_1 = new Profile();
        $pr_1->id = 'test1';
        $this->assertTrue(is_object($pr_1->build()));
        $this->assertTrue(is_object($pr_1->build(true)));

        $pr_2 = new Profile();
        $pr_2->id = 'test2';
        $pr_2->depends = 'test1';
        $this->assertTrue(is_object($pr_2->build()));

        $pr_3 = new Profile();
        $pr_3->id = 'test3';
        $pr_3->depends = ['test1', 'test2'];
        $this->assertTrue(is_object($pr_3->build()));

        $pr_4 = new Profile();
        $pr_4->id = 'test4';
        $pr_4->packages = 'pkg1';
        $this->assertTrue(is_object($pr_4->build()));

        $pr_5 = new Profile();
        $pr_5->id = 'test5';
        $pr_5->packages = ['pkg1', 'pkg2'];
        $this->assertTrue(is_object($pr_5->build()));
    }
}
