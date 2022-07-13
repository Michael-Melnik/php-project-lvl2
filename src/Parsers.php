<?php

namespace Differ\Parsers;

use Symfony\Component\Yaml\Yaml;

function parse(string $data, string $extension): array
{
    switch ($extension) {
        case 'yml':
        case 'yaml':
            return Yaml::parse($data);
        case 'json':
            return json_decode($data, true);
        default:
            throw new \Exception("Unknown extension: '{$extension}'!");
    }
}
