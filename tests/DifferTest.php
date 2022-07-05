<?php

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;
use function Differ\Differ\genDiff;

class DifferTest extends TestCase
{
    private string $path = __DIR__ . '/fixtures/';

    private function getFilePath($name)
    {
        return $this->path . $name;
    }

    public function testGenDiff()
    {
        $firstPathJson = $this->getFilePath('file1.json');
        $secondPathJson = $this->getFilePath('file2.json');
        $firstPathYaml = $this->getFilePath('file1.yaml');
        $secondPathYaml = $this->getFilePath('file2.yaml');
        $expectedStylish = trim(file_get_contents($this->getFilePath('resultStylish')));
        $this->assertEquals($expectedStylish, genDiff($firstPathJson, $secondPathJson, 'stylish'));
        $this->assertEquals($expectedStylish, genDiff($firstPathJson, $secondPathJson));
        $this->assertEquals($expectedStylish, genDiff($firstPathYaml, $secondPathYaml, 'stylish'));
        $this->assertEquals($expectedStylish, genDiff($firstPathYaml, $secondPathYaml));
    }
}