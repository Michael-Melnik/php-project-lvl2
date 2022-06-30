<?php

namespace Differ\Parsers;

use Symfony\Component\Yaml\Yaml;

function parse(string $fileName)
{
    $extensionFile = pathinfo($fileName)['extension'];
    switch ($extensionFile) {
        case 'yml':
        case 'yaml':
            $data = getDataFromAFile($fileName);
            return Yaml::parse($data);
        case 'json':
            $data = getDataFromAFile($fileName);
            return json_decode($data);
        default:
            throw new \Exception("uknown extension: '{$extensionFile}'!");
    }
}

function getDataFromAFile(string $fileName)
{
    $path1 = __DIR__ . "/../tests/fixtures/{$fileName}";
    $path2 = $fileName;
    if (file_exists($path1)) {
        return file_get_contents($path1);
    } else {
        throw new \Exception("File not found: {$path1}!");
    }
}
