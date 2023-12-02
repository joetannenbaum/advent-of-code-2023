<?php

use function Laravel\Prompts\info;

require __DIR__ . '/../vendor/autoload.php';

$input = file_get_contents(__DIR__ . '/input.txt');

$items = explode(PHP_EOL, $input);

$total = 0;

foreach ($items as $item) {
    $numbers = preg_match_all('/\d/', $item, $matches);
    $digits = $matches[0];
    $first = array_shift($digits);
    $last = array_pop($digits) ?? $first;

    $number = $first . $last;

    info($item . ': ' . $number);

    $total += $number;
}

info('Total: ' . $total);
