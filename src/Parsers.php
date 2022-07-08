<?php

namespace Differ\Parsers;

use Symfony\Component\Yaml\Yaml;

function parse(string $fileName): array
{
    $extensionFile = pathinfo($fileName, PATHINFO_EXTENSION);
    switch ($extensionFile) {
        case 'yml':
        case 'yaml':
            $data = getDataFromAFile($fileName);
            return Yaml::parse($data);
        case 'json':
            $data = getDataFromAFile($fileName);
            return json_decode($data, true);
        default:
            throw new \Exception("Unknown extension: '{$extensionFile}'!");
    }
}

function getDataFromAFile(string $fileName): string
{
    $path1 = $fileName;
    $path2 = __DIR__ . "/../{$fileName}";
    if (file_exists($path1)) {
        return readFile($path1);
    } elseif (file_exists($path2)) {
        return readFile($path2);
    } else {
        throw new \Exception("File not found: {$fileName}!");
    }
}

function readFile(string $path): string
{
    $fileContent = file_get_contents($path);
    if ($fileContent === false) {
        throw new \Exception("Can't read file: {$path}");
    }
    return $fileContent;
}
