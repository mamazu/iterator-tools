<?php

declare(strict_types=1);

namespace Mamazu\IteratorTools;

class IteratorTools {
    public function iterator_filter(iterable $iterable, callable $func): iterable {
        foreach($iterable as $item) {
            if ($func($item)) {
                yield $item;
            }
        }
    }

    public function iterator_map(iterable $iterable, callable $func): iterable {
        foreach($iterable as $item) {
            yield $func($item);
        }
    }

    public function iterator_reduce(iterable $iterable, callable $func, $startValue = null) {
        $value = $startValue;
        foreach($iterable as $item) {
            $value = $func($value, $item);
        }
        return $value;
    }

    public function create_from_array(array $data): iterable
    {
        yield from $data;
    }

    public function create_from_filename(string $fileName): iterable
    {
        return $this->create_from_file_handle(fopen($fileName, 'r'));
    }

    public function create_from_file_handle(resource $handle): iterable
    {
        while (($buffer = fgets($handle)) !== false) {
            yield $buffer;
        }
    }
}