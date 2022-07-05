<?php

namespace Differ\Formatters;

use Differ\Formats\Stylish;

function formatSelection($tree, string $format)
{
    switch ($format) {
        case 'stylish':
           return Stylish\format($tree);
        default:
            throw new \Exception("Unknown format: {$format}");
    }
}