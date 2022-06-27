<?php

namespace Differ\Tests;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use function Differ\Differ\genDiff;

class DifferTest extends TestCase
{
    public function testGenDiff()
    {
        $result = join("\n", ["{",
            "  - follow: false",
            "    host: hexlet.io",
            "  - proxy: 123.234.53.22",
            "  - timeout: 50",
            "  + timeout: 20",
            "  + verbose: true",
            "}"]) . "\n";
       $this->assertEquals($result, genDiff('file1.json', 'file2.json'));
    }
}