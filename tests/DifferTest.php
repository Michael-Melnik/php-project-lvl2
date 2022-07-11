<?php

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

class DifferTest extends TestCase
{
    private string $path = __DIR__ . '/fixtures/';

    private function getFilePath(string $name): string
    {
        return $this->path . $name;
    }

//    public function testGenDiff(): void
//    {
//        $firstPathJson = $this->getFilePath('file1.json');
//        $secondPathJson = $this->getFilePath('file2.json');
//        $firstPathYaml = $this->getFilePath('file1.yaml');
//        $secondPathYaml = $this->getFilePath('file2.yaml');
//        $expectedStylish = trim(file_get_contents($this->getFilePath('resultStylish')));
//        $expectedPlain = trim(file_get_contents($this->getFilePath('resultPlain')));
//        $expectedJson = trim(file_get_contents($this->getFilePath('resultJson')));
//        $this->assertEquals($expectedStylish, genDiff($firstPathJson, $secondPathJson, 'stylish'));
//        $this->assertEquals($expectedStylish, genDiff($firstPathJson, $secondPathJson));
//        $this->assertEquals($expectedStylish, genDiff($firstPathYaml, $secondPathYaml, 'stylish'));
//        $this->assertEquals($expectedStylish, genDiff($firstPathYaml, $secondPathYaml));
//        $this->assertEquals($expectedPlain, genDiff($firstPathYaml, $secondPathYaml, 'plain'));
//        $this->assertEquals($expectedJson, genDiff($firstPathJson, $secondPathJson, 'json'));
//    }
    /**
     * @dataProvider formatProvider
     */
    public function testDefault($format)
    {
        $firstPath = $this->getFilePath("file1.{$format}");
        $secondPath = $this->getFilePath("file2.{$format}");
        $expected = trim(file_get_contents($this->getFilePath('resultStylish')));
        $this->assertEquals($expected, genDiff($firstPath, $secondPath));
    }
    /**
     * @dataProvider formatProvider
     */
    public function testJson($format)
    {
        $firstPath = $this->getFilePath("file1.{$format}");
        $secondPath = $this->getFilePath("file2.{$format}");
        $expected = trim(file_get_contents($this->getFilePath('resultJson')));
        $this->assertEquals($expected, genDiff($firstPath, $secondPath, 'json'));
    }

    /**
     * @dataProvider formatProvider
     */
    public function testPlain($format)
    {
        $firstPath = $this->getFilePath("file1.{$format}");
        $secondPath = $this->getFilePath("file2.{$format}");
        $expected = trim(file_get_contents($this->getFilePath('resultPlain')));
        $this->assertEquals($expected, genDiff($firstPath, $secondPath, 'plain'));
    }
    /**
     * @dataProvider formatProvider
     */
    public function testStylish($format)
    {
        $firstPath = $this->getFilePath("file1.{$format}");
        $secondPath = $this->getFilePath("file2.{$format}");
        $expected = trim(file_get_contents($this->getFilePath('resultStylish')));
        $this->assertEquals($expected, genDiff($firstPath, $secondPath, 'stylish'));
    }

    public function formatProvider()
    {
        return [
            ['json'],
            ['yaml']
        ];
    }
}
