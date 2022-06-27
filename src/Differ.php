<?php

namespace Differ\Differ;

function genDiff(string $fileName1, string $fileName2)
{
    $dataFile1 = json_decode(getDataFromAFile($fileName1), true);
    $dataFile2 = json_decode(getDataFromAFile($fileName2), true);
//
    $dataFile1 = convertBollValue($dataFile1);
    $dataFile2 = convertBollValue($dataFile2);
    $keys = array_unique(array_merge(array_keys($dataFile1), array_keys($dataFile2)));
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

function getDataFromAFile(string $fileName)
{
    $path = __DIR__ . "/../tests/fixtures/{$fileName}";
    if (file_exists($path)) {
        return file_get_contents($path);
    } else {
        throw new \Exception("File not found: {$path}!");
    }
}

function convertBollValue(array $data)
{
    return array_map(function ($item) {
        if (is_bool($item)) {
            return $item ? 'true' : 'false';
        }
        return $item;
    }, $data);
}
