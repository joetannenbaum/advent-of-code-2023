<?php

function astInRange($astPos, $match): bool
{
    return $astPos >= $match[1] - 1 && $astPos <= $match[1] + strlen($match[0]);
}

function getValidGears(array $input): array
{
    $valid = [];

    foreach ($input as $index => $line) {
        preg_match_all('/\*/', $line, $matches, PREG_OFFSET_CAPTURE);

        foreach ($matches[0] as $set) {
            $validForAst = [];

            $linesToSearch = [
                $input[$index - 1] ?? '',
                $line,
                $input[$index + 1] ?? '',
            ];

            foreach ($linesToSearch as $searchLine) {
                preg_match_all('/\d+/', $searchLine, $searchLine, PREG_OFFSET_CAPTURE);

                $validForAst = array_merge(
                    $validForAst,
                    array_filter($searchLine[0], fn ($pl) => astInRange($set[1], $pl)),
                );
            }

            if (count($validForAst) === 2) {
                $valid[] = array_map(fn ($v) => (int) $v[0], $validForAst);
            }
        }
    }

    return $valid;
}
