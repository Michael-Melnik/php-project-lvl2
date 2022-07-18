<?php

namespace Differ\Formatters\Stylish;

function format(array $tree, int $depth = 0, int $spacesCount = 4): string
{
    $indent = str_repeat(' ', $spacesCount * $depth);
    $lines = array_map(function ($item) use ($indent, $depth, $spacesCount): string {
        $key = $item['key'];
        switch ($item['type']) {
            case 'removed':
                $value = stringify($item['value'], $depth, $spacesCount);
                return "{$indent}  - {$key}: {$value}";
            case 'added':
                $value = stringify($item['value'], $depth, $spacesCount);
                return "{$indent}  + {$key}: {$value}";
            case 'unchanged':
                $value = stringify($item['value'], $depth, $spacesCount);
                return "{$indent}    {$key}: {$value}";
            case 'changed':
                $oldValue = stringify($item['oldValue'], $depth, $spacesCount);
                $newValue = stringify($item['newValue'], $depth, $spacesCount);
                return "{$indent}  - {$key}: {$oldValue}\n{$indent}  + {$key}: {$newValue}";
            case 'parent':
                $value = format($item['children'], $depth + 1);
                return "{$indent}    {$key}: {$value}";
            default:
                throw new \Exception("Unknown property: {$item['type']}");
        }
    }, $tree);
    return implode("\n", ["{", ...$lines, "{$indent}}"]);
}

function stringify(mixed $value, int $depth, int $spaceCount): string
{
    if (!is_array($value)) {
        return toString($value);
    }

    $stringifyValue = function ($currentValue, $depth) use ($spaceCount): string {
        $indent = str_repeat(' ', $depth * $spaceCount);
        $iter = function ($value, $key) use ($depth, $spaceCount, $indent): string {
            $formattedValue = stringify($value, $depth, $spaceCount);
            return "{$indent}    {$key}: {$formattedValue}";
        };
        $strValue = array_map($iter, (array) $currentValue, array_keys((array) $currentValue));
        return implode("\n", ["{", ...$strValue, "{$indent}}"]);
    };
    return $stringifyValue($value, $depth + 1);
}

function toString(mixed $value): string
{
    if ($value === null) {
        return 'null';
    }
    return trim(var_export($value, true), "'");
}
