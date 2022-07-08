<?php

namespace Differ\Parsers;

use Symfony\Component\Yaml\Yaml;

function parse(string $fileName): object
{
    $extensionFile = pathinfo($fileName, PATHINFO_EXTENSION);
    switch ($extensionFile) {
        case 'yml':
        case 'yaml':
            $data = getDataFromAFile($fileName);
            return Yaml::parse($data, Yaml::PARSE_OBJECT_FOR_MAP);
        case 'json':
            $data = getDataFromAFile($fileName);
            return json_decode($data);
        default:
            throw new \Exception("Unknown extension: '{$extensionFile}'!");
    }
}

function getDataFromAFile(string $fileName): string|false
{
    $path1 = $fileName;
    $path2 = __DIR__ . "/../{$fileName}";
    if (file_exists($path1)) {
        return file_get_contents($path1);
    } elseif (file_exists($path2)) {
        return file_get_contents($path2);
    } else {
        throw new \Exception("File not found: {$path1}!");
    }
}
