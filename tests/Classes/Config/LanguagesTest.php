<?php namespace WPKG\Classes\Config;

use PHPUnit\Framework\TestCase;

class LanguagesTest extends TestCase
{
    public function test__construct()
    {
        try {
            $languages = new Languages();
            $this->assertTrue(is_object($languages));
        } catch (\Exception $e) {
            $this->assertContains('Must be initialized ', $e->getMessage());
        }
    }

    public function testLoad()
    {
        $languages = new Languages();
        $lng = $languages->load('english');
        $this->assertTrue(is_array($lng));
        $this->assertEquals(count($lng), 2);
    }
}
