<?php

declare(strict_types=1);

namespace tests\Mamazu\IteratorTools;

use PHPUnit\Framework\TestCase;
use function Mamazu\IteratorTools\array_to_iterator;
use function Mamazu\IteratorTools\iterator_filter;
use function Mamazu\IteratorTools\iterator_map;
use function Mamazu\IteratorTools\iterator_reduce;

class IteratorsTest extends TestCase {
    public function test_iterator_filter(): void {
        $generator = static function () { yield from [1, 2, 3, 4, 5, 6, 7, 8, 9]; };

        $result = iterator_filter($generator(), static function ($x) {return $x % 2 === 0; } );
        $array_result = $this->unroll($result);
        $this->assertCount(4, $array_result);
        $this->assertSame($array_result, [2, 4, 6, 8]);
    }

    public function test_iterator_filter_with_empty_result(): void {
        $generator = static function () { yield from [1, 2, 3, 4, 5, 6, 7, 8, 9]; };

        $result = iterator_filter($generator(), static function ($x) {return $x > 10; } );
        $array_result = $this->unroll($result);
        $this->assertCount(0, $array_result);
        $this->assertSame($array_result, []);
    }

    public function test_iterator_map(): void {
        $generator = static function () { yield from [1, 2, 3, 4, 5, 6, 7, 8, 9]; };

        $result = iterator_map($generator(), static function ($x) { return $x * 2; });

        $array_result = $this->unroll($result);
        $this->assertCount(9, $array_result);
        $this->assertSame($array_result, [2, 4, 6, 8, 10, 12, 14, 16, 18]);
    }

    public function test_iterator_reduce(): void {
        $generator = static function () { yield from [1, 2, 3, 4, 5, 6, 7, 8, 9]; };

        $result = iterator_reduce(
            $generator(),
            static function (int $carry, int $item) { return $carry + $item; },
            0
        );
        $this->assertSame($result, 45);
    }

    public function test_iterator_reduce_with_null(): void {
        $generator = static function () { yield from [1, 2, 3, 4, 5, 6, 7, 8, 9]; };

        $result = iterator_reduce(
            $generator(),
            static function (?int $carry, int $item) { return ($carry ?? 0) + $item; }
        );
        $this->assertSame($result, 45);
    }

    public function test_iterator_from_array(): void {
        $result = array_to_iterator([1, 2, 3, 4, 5, 6, 7, 8, 9]);

        $this->assertEquals($this->unroll($result), [1, 2, 3, 4, 5, 6, 7, 8, 9]);
    }

    public function test_range_inclusive(): void
    {
        $result = range(1, 10);
        $this->assertEquals($this->unroll($result), [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);
    }

    public function test_range_inclusive_with_step(): void
    {
        $result = range(0, 10, 2);
        $this->assertEquals($this->unroll($result), [0, 2, 4, 6, 8, 10]);
    }

    public function test_range_inclusive_with_step_as_float(): void
    {
        $result = range(0, 5, 1.5);
        $this->assertEquals($this->unroll($result), [0.0, 1.5, 3.0, 4.5]);
    }

    private function unroll(iterable $iterable): array {
        $array = [];
        foreach($iterable as $item) {
            $array[] = $item;
        }

        return $array;
    }
}
