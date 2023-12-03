<?php

use function Laravel\Prompts\info;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/helpers.php';

$input = inputAsArray(__DIR__);

$valid = getValidGears($input);

$total = 0;

foreach ($valid as $set) {
    $total += ($set[0] * $set[1]);
}

info('Total: ' . $total);
