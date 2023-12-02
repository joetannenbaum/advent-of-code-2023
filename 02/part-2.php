<?php

use function Laravel\Prompts\info;

require __DIR__ . '/../vendor/autoload.php';

$input = file_get_contents(__DIR__ . '/input.txt');

$games = explode(PHP_EOL, $input);

function getSet(string $set): array
{
    $set = explode(',', $set);
    $set = array_map('trim', $set);
    $set = array_map(function ($s) {
        [$quantity, $color] = explode(' ', $s);

        return [
            $color => (int) $quantity,
        ];
    }, $set);

    return array_reduce($set, fn ($prev, $carry) =>  array_merge($prev, $carry), []);
}

$games = array_map(function ($game) {
    [$gameId, $sets] = explode(':', $game);

    $id = str_replace('Game ', '', $gameId);
    $sets = array_map('getSet', explode(';', $sets));

    return [
        'id'   => (int) $id,
        'sets' => $sets,
    ];
}, $games);

$total = 0;

$colors = ['red', 'blue', 'green'];

foreach ($games as $game) {
    $mins = [];

    foreach ($colors as $color) {
        $mins[] = max(array_map(fn ($set) => $set[$color] ?? 0, $game['sets']));
    }

    $total += ($mins[0] * $mins[1] * $mins[2]);
}

info('Total: ' . $total);
