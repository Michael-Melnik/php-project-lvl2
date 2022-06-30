<?php

namespace Differ\Differ;

use function Differ\Parsers\parse;

function genDiff(string $fileName1, string $fileName2)
{
    $dataFile1 = (array)parse($fileName1);
    $dataFile2 = (array)parse($fileName2);
    $dataFile1 = convertBollValue($dataFile1);
    $dataFile2 = convertBollValue($dataFile2);
    $keys = array_unique(array_merge(array_keys((array)$dataFile1), array_keys((array)$dataFile2)));
    sort($keys);
    $diff = array_reduce($keys, function ($acc, $key) use ($dataFile1, $dataFile2) {
        if (array_key_exists($key, $dataFile1) && array_key_exists($key, $dataFile2)) {
            if ($dataFile1[$key] === $dataFile2[$key]) {
                $acc[] = "    {$key}: {$dataFile1[$key]}";
                return $acc;
            }
            $acc[] = "  - {$key}: {$dataFile1[$key]}";
            $acc[] = "  + {$key}: {$dataFile2[$key]}";
            return $acc;
        } elseif (array_key_exists($key, $dataFile1)) {
            $acc[] = "  - {$key}: $dataFile1[$key]";
            return $acc;
        } else {
            $acc[] = "  + {$key}: {$dataFile2[$key]}";
            return $acc;
        }
    }, []);

    return "{\n" . implode("\n", $diff) . "\n}\n";
}



function convertBollValue($data)
{
    return array_map(function ($item) {
        if (is_bool($item)) {
            return $item ? 'true' : 'false';
        }
        return $item;
    }, $data);
}
