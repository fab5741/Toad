<?php

namespace Tests\Framework;

use Framework\App;
use PHPUnit\Framework\TestCase;

class AppTest extends TestCase
{
    public function testRun()
    {
        $this->assertEquals("HelloWorld", (new App())->run());
    }
}
