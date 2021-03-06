<?php

namespace Differ\Formatters;

use Differ\Formatters\Stylish;
use Differ\Formatters\Plain;
use Differ\Formatters\Json;

function formatSelection(array $tree, string $format): string
{
    switch ($format) {
        case 'stylish':
            return Stylish\format($tree);
        case 'plain':
            return Plain\format($tree);
        case 'json':
            return Json\format($tree);
        default:
            throw new \Exception("Unknown format: {$format}");
    }
}
