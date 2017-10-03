<?php

namespace Tests\Framework\Translator;

use Framework\Exceptions\TranslateNotFoundException;
use Framework\Translator\ArrayTranslator;
use PHPUnit\Framework\TestCase;

class ArrayTranslatorTest extends TestCase
{
    /**
     * @var ArrayTranslator
     */
    private $translator;

    /**
     * Test if Translator construct well
     */
    public function setUp()
    {
        $this->translator = new ArrayTranslator();
    }

    public function testSetAndGet()
    {
        $this->translator->set("test", "fr", "TestFR");

        $this->assertTrue($this->translator->has("test", "fr"));
        $this->assertEquals("TestFR", $this->translator->get("test", "fr"));
    }

    public function testMultipleLang()
    {
        $this->translator->set("test", "fr", "TestFR");
        $this->translator->set("test", "eng", "testEng");
        $this->translator->set("test", "IT", "TestIT");

        $this->assertEquals("TestFR", $this->translator->get("test", "fr"));
        $this->assertEquals("testEng", $this->translator->get("test", "eng"));
        $this->assertEquals("TestIT", $this->translator->get("test", "IT"));
    }

    public function testDefaultGet()
    {
        $this->assertEquals("default", $this->translator->get("test", "IT", "default"));
    }

    public function testNotfound()
    {
        $this->translator->set("test", "fr", "TestFR");
        $this->expectException(TranslateNotFoundException::class);
        $this->translator->get("test", "IT");
    }
}
