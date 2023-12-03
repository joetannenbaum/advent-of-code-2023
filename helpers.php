<?php

function inputAsArray($dir, $filename = null)
{
    return explode(PHP_EOL, file_get_contents($filename ?? $dir . '/input.txt'));
}
