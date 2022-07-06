<?php

namespace Differ\Formatters\Json;

function format($tree)
{
    return json_encode($tree);
}
