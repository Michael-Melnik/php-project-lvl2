<?php

namespace Differ\Differ;


use function Differ\Formatters\formatSelection;
use function Differ\Parsers\parse;

function genDiff(string $fileName1, string $fileName2, string $format = 'stylish')
{
    $dataFile1 = parse($fileName1);
    $dataFile2 = parse($fileName2);
    $data = compare($dataFile1, $dataFile2);
    $a =  formatSelection($data, $format);
    return $a;
}

function compare($data1, $data2) : array
{
    $data1 = (array)$data1;
    $data2 = (array)$data2;
    $keys = array_unique([...array_keys($data1), ...array_keys($data2)]);
    sort($keys);
    $tree = array_map(function($key) use ($data1, $data2) {
        if (!array_key_exists($key, $data1)) {
            return [
                'key' => $key,
                'value' => $data2[$key],
                'type' => 'added'
            ];
        } elseif (!array_key_exists($key, $data2)) {
            return [
                'key' => $key,
                'value' => $data1[$key],
                'type' => 'removed'
            ];
        } else {
            if (is_object($data1[$key]) && is_object($data2[$key])) {
            return [
                'key' => $key,
                'type' => 'parent',
                'children' => compare($data1[$key], $data2[$key])
            ];
            } elseif ($data1[$key] === $data2[$key]) {
                return [
                    'key' => $key,
                    'value' => $data1[$key],
                    'type' => 'unchanged'
                ];
            } else{
                return [
                    'key' => $key,
                    'oldValue' => $data1[$key],
                    'newValue' => $data2[$key],
                    'type' => 'changed'
                ];
            }
        }
    }, $keys);
    return $tree;
}