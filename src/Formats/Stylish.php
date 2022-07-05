<?php

namespace Differ\Formats\Stylish;


function format($tree, $depth = 0, $spacesCount = 4) : string
{
    $indent = str_repeat(' ', $spacesCount * $depth);
    $lines = array_map(function ($item) use ($indent, $depth, $spacesCount): string {
        $key = $item['key'];
        switch ($item['type']) {
            case 'removed':
                $value = stringify($item['value'], $depth,$spacesCount);
                return "{$indent}  - {$key}: {$value}" ;
            case 'added':
                $value = stringify($item['value'], $depth, $spacesCount);
                return "{$indent}  + {$key}: {$value}" ;
            case 'unchanged':
                $value = stringify($item['value'], $depth,$spacesCount);
                return "{$indent}    {$key}: {$value}" ;
            case 'changed':
                $oldValue = stringify($item['oldValue'], $depth, $spacesCount);
                $newValue = stringify($item['newValue'], $depth, $spacesCount);
                $a = "{$indent}  - {$key}: {$oldValue}" ;
                $b = "{$indent}  + {$key}: {$newValue}";
               return "{$a}\n{$b}";
            case 'parent':
                $value = format($item['children'], $depth + 1);
                return "{$indent}    {$key}: {$value}";
            default:
                throw new \Exception("Unknown property: {$item['type']}");
            }
        }, $tree);
        return implode("\n", ["{", ...$lines, "{$indent}}"]);
}

function stringify($value, $depth, $spaceCount)
{
    if(is_object($value)) {
        $value = (array)$value;
    }
    if (!is_array($value)) {
        return toString($value);
    }

    $stringifyValue = function ($currentValue, $depth) use ($spaceCount) : string {
    $indent = str_repeat(' ', $depth * $spaceCount);;
    $iter = function ($value, $key) use ($depth, $spaceCount, $indent): string {
        $formattedValue = stringify($value, $depth, $spaceCount);
        return "{$indent}    {$key}: {$formattedValue}";
    };
    $strValue = array_map($iter, (array) $currentValue, array_keys((array) $currentValue));
    return implode("\n", ["{", ...$strValue, "{$indent}}"]);
    };
    return $stringifyValue($value, $depth + 1);
}

function toString($value) : string
{
    if($value === null) {
        return 'null';
    }
    return trim(var_export($value, true), "'");
}
