<?php

namespace Differ\Formatters\Plain;

use function Functional\flatten;

function format(array $tree): string
{
    $plain = stringify($tree);
    return implode("\n", flatten($plain));
}

function stringify(array $tree, string $path = ''): array
{
    return array_map(function ($item) use ($path) {
        $key = $item['key'];
        switch ($item['type']) {
            case 'removed':
                return "Property '{$path}{$key}' was removed";
            case 'added':
                $value = toString($item['value']);
                return "Property '{$path}{$key}' was added with value: {$value}";
            case 'unchanged':
                return [];
            case 'changed':
                $oldValue = toString($item['oldValue']);
                $newValue = toString($item['newValue']);
                return "Property '{$path}{$key}' was updated. From {$oldValue} to {$newValue}";
            case 'parent':
                $newPath = "{$path}{$key}.";
                return stringify($item['children'], $newPath);
            default:
                throw new \Exception("Unknown property: {$item['type']}");
        }
    }, $tree);
}

function toString($value): string
{
    if (is_object($value)) {
        return '[complex value]';
    }
    if ($value === null) {
        return 'null';
    }
    return var_export($value, true);
}
