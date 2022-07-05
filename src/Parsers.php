<?php

namespace Differ\Parsers;

use Symfony\Component\Yaml\Yaml;

function parse(string $fileName)
{
    $extensionFile = pathinfo($fileName, PATHINFO_EXTENSION);
    switch ($extensionFile) {
        case 'yml':
        case 'yaml':
            $data = getDataFromAFile($fileName);
            return Yaml::parse($data,  Yaml::PARSE_OBJECT_FOR_MAP);
        case 'json':
            $data = getDataFromAFile($fileName);
            return json_decode($data);
        default:
            throw new \Exception("Unknown extension: '{$extensionFile}'!");
    }
}

function getDataFromAFile(string $fileName)
{
    $path1 = $fileName;
    $path2 = __DIR__ . "/../{$fileName}";
    if (file_exists($path1)) {
        return file_get_contents($path1);
    } elseif(file_exists($path2)) {
        return file_get_contents($path2);
    } else {
        throw new \Exception("File not found: {$path1}!");
    }
}
















/////////////////////////////////////////////////////////////////////////////////////////
///
function stringify($value, int $depth): string
{
    if (!is_object($value)) {
        return toString($value);
    }

    $stringifyValue = function ($currentValue, $depth): string {
        $indent = getIndent($depth);
        $iter = function ($value, $key) use ($depth, $indent): string {
            $formattedValue = stringify($value, $depth);
            return "{$indent}    {$key}: {$formattedValue}";
        };

        $stringifiedValue = array_map($iter, (array) $currentValue, array_keys((array) $currentValue));
        return implode("\n", ["{", ...$stringifiedValue, "{$indent}}"]);
    };
    return $stringifyValue($value, $depth + 1);
}
/**
 * Transform $differTree to string
 * @param array<mixed> $tree differTree
 * @return string
 */
function format(array $tree, int $depth = 0): string
{
    $indent = getIndent($depth);
    $lines = array_map(function ($item) use ($indent, $depth) {
        $key = $item['key'];
        switch ($item['type']) {
            case 'deleted':
                $value = stringify($item['value'], $depth);
                $line = "{$indent}  - {$key}: {$value}";
                break;
            case 'unchanged':
                $value = stringify($item['value'], $depth);
                $line = "{$indent}    {$key}: {$value}";
                break;
            case 'added':
                $value = stringify($item['value'], $depth);
                $line = "{$indent}  + {$key}: {$value}";
                break;
            case 'changed':
                $oldValue = stringify($item['oldValue'], $depth);
                $newValue = stringify($item['newValue'], $depth);
                $line = "{$indent}  - {$key}: {$oldValue}\n{$indent}  + {$key}: {$newValue}";
                break;
            case 'parent':
                $value = format($item['children'], $depth + 1);
                $line = "{$indent}    {$key}: {$value}";
                break;
            default:
                throw new Exception('Unknown type of item');
        }
        return $line;
    }, $tree);
    return implode("\n", ["{", ...$lines, "{$indent}}"]);
}





/////////////////////////////////////////////
///
///
///
///
///
///
/// function stringify($tree, $depth = 1, $spacesCount = 2)
//{
//    $currentIndent = str_repeat(':', $spacesCount * $depth);
//    $lines = array_map(function ($item) use ($currentIndent, $depth): string {
//        $key = $item['key'];
//        switch ($item['type']) {
//            case 'deleted':
//                $value = stringOblect($item['value'], $depth);
//                return "{$currentIndent}- {$key}: {$value}" ;
//            case 'added':
//                $value = stringOblect($item['value'], $depth);
//                return "{$currentIndent}+ {$key}: {$value}" ;
//            case 'unchanged':
//                $value = stringOblect($item['value'], $depth);
//                return "{$currentIndent}  {$key}: {$value}" ;
//            case 'changed':
//                $oldValue = stringOblect($item['oldValue'], $depth);
//                $newValue = stringOblect($item['newValue'], $depth);
//                $a = "{$currentIndent}- {$key}: {$oldValue}" ;
//                $b = "{$currentIndent}+ {$key}: {$newValue}";
//               return "{$a}\n{$b}";
//            case 'parent':
//                $value = stringify($item['children'], $depth + 1,2);
//                return "{$currentIndent}  {$key}: {$value}";
//            default:
//                return '1';
//            }
//        }, $tree);
//        return implode("\n", ["{", ...$lines, "{$currentIndent}}"]);
//}
//
//function stringOblect($value, $depth, $spaceCount = 2)
//{
//    if(is_object($value)) {
//        $value = (array)$value;
//    }
//    if (!is_array($value)) {
//        return toString($value);
//    }
//    print_r($value);
//    print_r("\n");
//    return 1;
////    $toString = function ($value, $depth) use ($spaceCount) : string {
////
////        $indent = str_repeat('*', $depth * $spaceCount);
////
////        $lines = array_map(function ($key, $item) use ($indent): string {
////            return "{$indent}  {$key}: {$iter($item, $depth + 1, $shift + 2)}";
////        }, array_keys($value), $value);
////        return implode("\n", ["{", ...$lines, "{$indent}}"]);
////
////    };
////    return $toString($value, $depth);
//
//}