<?php

use function Laravel\Prompts\info;

require __DIR__ . '/../vendor/autoload.php';

$input = file_get_contents(__DIR__ . '/input.txt');

$items = explode(PHP_EOL, $input);

$total = 0;

function getPositions(string $searchFor, string $subject): array
{
    $searchFor = (string) $searchFor;

    $positions = [];

    $offset = 0;

    while (($pos = strpos($subject, $searchFor, $offset)) !== false) {
        $positions[] = $pos;
        $offset = $pos + 1;
    }

    if ($positions === []) {
        return [];
    }

    return [$searchFor, $positions];
}

foreach ($items as $item) {
    $mapping = [
        'one'   => 1,
        'two'   => 2,
        'three' => 3,
        'four'  => 4,
        'five'  => 5,
        'six'   => 6,
        'seven' => 7,
        'eight' => 8,
        'nine'  => 9,
    ];

    $positions = [];

    foreach ($mapping as $key => $value) {
        $positions[] = getPositions($key, $item);
        $positions[] = getPositions($value, $item);
    }

    $positions = array_values(array_filter($positions, fn ($p) => count($p) > 0));

    $lowest = $positions[0][1][0];
    $highest = $positions[0][1][0];

    $first = $positions[0][0];
    $last = $positions[0][0];

    foreach ($positions as $p) {
        $min = min($p[1]);
        $max = max($p[1]);

        if ($min < $lowest) {
            $lowest = $min;
            $first = $p[0];
        }

        if ($max > $highest) {
            $highest = $max;
            $last = $p[0];
        }
    }

    $first = $mapping[$first] ?? $first;
    $last = $mapping[$last] ?? $last;

    $number = $first . $last;

    info($item . ': ' . $number);

    $total += $number;
}

info('Total: ' . $total);
