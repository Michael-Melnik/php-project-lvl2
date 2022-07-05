<?php

namespace Differ\Formatters;

use Differ\Formatters\Stylish;
use Differ\Formatters\Plain;

function formatSelection($tree, string $format)
{
    switch ($format) {
        case 'stylish':
            return Stylish\format($tree);
        case 'plain':
            return Plain\format($tree);
        default:
            throw new \Exception("Unknown format: {$format}");
    }
}
