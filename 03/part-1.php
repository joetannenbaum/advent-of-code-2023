<?php

use function Laravel\Prompts\info;

require __DIR__ . '/../vendor/autoload.php';

$input = inputAsArray(__DIR__);

function getCharactersFromLine($line, $offset, $number): array
{
    $toMatch = [];

    foreach (range(max(0, $offset - 1), $offset + strlen($number)) as $lineOffset) {
        $toMatch[] = $line[$lineOffset] ?? '.';
    }

    return $toMatch;
}

function getValidNumbers(array $input): array
{
    $valid = [];

    foreach ($input as $index => $line) {
        preg_match_all('/\d+/', $line, $matches, PREG_OFFSET_CAPTURE);

        foreach ($matches[0] as $set) {
            $number = $set[0];
            $offset = $set[1];

            $toMatch = [];

            if ($offset > 0) {
                // Character before
                $toMatch[] = $line[$offset - 1];
            }

            if ($offset + strlen($number) < strlen($line)) {
                // Character after
                $toMatch[] = $line[$offset + strlen($number)];
            }

            if ($index > 0) {
                // Line above including 1 character before and after
                $toMatch = array_merge(
                    $toMatch,
                    getCharactersFromLine($input[$index - 1], $offset, $number),
                );
            }

            if ($index < count($input) - 1) {
                // Line below including 1 character before and after
                $toMatch = array_merge(
                    $toMatch,
                    getCharactersFromLine($input[$index + 1], $offset, $number),
                );
            }

            $symbols = array_filter($toMatch, fn ($tm) => $tm !== '.');

            if (count($symbols)) {
                $valid[] = (int) $number;
            }
        }
    }

    return $valid;
}

$valid = getValidNumbers($input);

info('Total: ' . array_sum($valid));
