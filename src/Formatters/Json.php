<?php

namespace Differ\Formatters\Json;

function format(array $tree): string|false
{
    return json_encode($tree);
}
