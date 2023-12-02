<?php

use function Laravel\Prompts\info;
use function Laravel\Prompts\warning;

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

$maxes = [
    'red'   => 12,
    'green' => 13,
    'blue'  => 14,
];

foreach ($games as $game) {
    $invalidSets = array_filter($game['sets'], function ($s) use ($maxes) {
        foreach ($maxes as $color => $value) {
            if ($value < ($s[$color] ?? 0)) {
                return true;
            }
        }

        return false;
    });

    if (count($invalidSets) > 0) {
        warning('Impossible game! ' . json_encode($game));
    } else {
        info('Game could have happened. ' . json_encode($game));
        $total += $game['id'];
    }
}

info('Total: ' . $total);
