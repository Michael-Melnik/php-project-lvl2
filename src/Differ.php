<?php

namespace Differ\Differ;

use function Differ\Formatters\formatSelection;
use function Differ\Parsers\parse;

function genDiff(string $fileName1, string $fileName2, string $format = 'stylish'): string
{
    $dataFile1 = parse(getDataFromAFile($fileName1), getExtension($fileName1));
    $dataFile2 = parse(getDataFromAFile($fileName2), getExtension($fileName2));
    $diff = compare($dataFile1, $dataFile2);
    return formatSelection($diff, $format);
}

function compare(array $data1, array $data2): array
{
    $keys = array_unique([...array_keys($data1), ...array_keys($data2)]);
    $tree = array_map(function ($key) use ($data1, $data2) {
        if (!array_key_exists($key, $data1)) {
            return [
                'key' => $key,
                'value' => $data2[$key],
                'type' => 'added'
            ];
        }
        if (!array_key_exists($key, $data2)) {
            return [
                'key' => $key,
                'value' => $data1[$key],
                'type' => 'removed'
            ];
        }
        if (is_array($data1[$key]) && is_array($data2[$key])) {
            return [
                'key' => $key,
                'type' => 'parent',
                'children' => compare($data1[$key], $data2[$key])
            ];
        }
        if ($data1[$key] === $data2[$key]) {
                return [
                    'key' => $key,
                    'value' => $data1[$key],
                    'type' => 'unchanged'
                ];
        }
        return [
            'key' => $key,
            'oldValue' => $data1[$key],
            'newValue' => $data2[$key],
            'type' => 'changed'
        ];
    }, \Functional\sort($keys, fn($a, $b) => strcmp($a, $b)));
    return $tree;
}

function getDataFromAFile(string $fileName): string
{
    $path1 = $fileName;
    $path2 = __DIR__ . "/../{$fileName}";
    if (file_exists($path1)) {
        return readFile($path1);
    }
    if (file_exists($path2)) {
        return readFile($path2);
    }
    throw new \Exception("File not found: {$fileName}!");
}

function readFile(string $path): string
{
    $fileContent = file_get_contents($path);
    if ($fileContent === false) {
        throw new \Exception("Can't read file: {$path}");
    }
    return $fileContent;
}

function getExtension(string $path): string
{
    return pathinfo($path, PATHINFO_EXTENSION);
}
