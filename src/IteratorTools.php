<?php

declare(strict_types=1);

namespace Mamazu\IteratorTools;

function iterator_filter(iterable $iterable, callable $func): iterable
{
    foreach ($iterable as $item) {
        if ($func($item)) {
            yield $item;
        }
    }
}

function iterator_map(iterable $iterable, callable $func): iterable
{
    foreach ($iterable as $item) {
        yield $func($item);
    }
}

function iterator_reduce(iterable $iterable, callable $func, $startValue = null)
{
    $value = $startValue;
    foreach ($iterable as $item) {
        $value = $func($value, $item);
    }

    return $value;
}

function array_to_iterator(array $data): iterable
{
    yield from $data;
}

function file(string $fileName): iterable
{
    $handle = fopen($fileName, 'rb');
    while (($line = fgets($handle)) !== false) {
        yield $line;
    }
}
