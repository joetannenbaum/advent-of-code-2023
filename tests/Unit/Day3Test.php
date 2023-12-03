<?php

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../../03/helpers.php';

test('03-01', function () {
    $input = <<<'INPUT'
    467..114..
    ...*......
    ..35..633.
    ......#...
    617*......
    .....+.58.
    ..592.....
    ......755.
    ...$.*....
    .664.598..
    INPUT;

    $result = getValidNumbers(explode(PHP_EOL, $input));

    expect($result)->toBe([
        467,
        35,
        633,
        617,
        592,
        755,
        664,
        598,
    ]);
});

test('03-02', function () {
    $input = <<<'INPUT'
    467..114..
    ...*......
    ..35..633.
    ......#...
    617*......
    .....+.58.
    ..592.....
    ......755.
    ...$.*....
    .664.598..
    INPUT;

    $result = getValidGears(explode(PHP_EOL, $input));

    expect($result)->toBe([
        [467, 35],
        [755, 598],
    ]);
})->only();
