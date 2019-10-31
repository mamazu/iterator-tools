<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

include __DIR__.'/../src/GeneratorFunctions.php';

class GeneratorFunctionsTest extends TestCase {
    public function test_iterator_filter(): void {
        $generator = function () { yield from [1, 2, 3, 4, 5, 6, 7, 8, 9]; };

        $result = IteratorTools::iterator_filter($generator(), function ($x) {return $x % 2 === 0; } );
        $array_result = $this->unroll($result);
        $this->assertCount(4, $array_result);
        $this->assertSame($array_result, [2, 4, 6, 8]);
    }

    public function test_iterator_filter_with_empty_result(): void {
        $generator = function () { yield from [1, 2, 3, 4, 5, 6, 7, 8, 9]; };

        $result = IteratorTools::iterator_filter($generator(), function ($x) {return $x > 10; } );
        $array_result = $this->unroll($result);
        $this->assertCount(0, $array_result);
        $this->assertSame($array_result, []);
    }

    public function test_iterator_map(): void {
        $generator = function () { yield from [1, 2, 3, 4, 5, 6, 7, 8, 9]; };

        $result = IteratorTools::iterator_map($generator(), function ($x) { return $x * 2; });
        
        $array_result = $this->unroll($result);
        $this->assertCount(9, $array_result);
        $this->assertSame($array_result, [2, 4, 6, 8, 10, 12, 14, 16, 18]);
    }

    public function test_iterator_reduce(): void {
        $generator = function () { yield from [1, 2, 3, 4, 5, 6, 7, 8, 9]; };

        $result = IteratorTools::iterator_reduce(
            $generator(), 
            function (int $carry, int $item) { return $carry + $item; },
            0
        );
        $this->assertSame($result, 45);
    }
    
    public function test_iterator_reduce_with_null(): void {
        $generator = function () { yield from [1, 2, 3, 4, 5, 6, 7, 8, 9]; };

        $result = IteratorTools::iterator_reduce(
            $generator(), 
            function (?int $carry, int $item) { return ($carry ?? 0) + $item; }
        );
        $this->assertSame($result, 45);
    }
    
    public function test_iterator_from_array(): void {
        $result = IteratorTools::create_from_array([1, 2, 3, 4, 5, 6, 7, 8, 9]);

        $this->assertEquals($this->unroll($result), [1, 2, 3, 4, 5, 6, 7, 8, 9]);
    }
    
    private function unroll(iterable $iterable): array {
        $array = [];
        foreach($iterable as $item) {
            $array[] = $item;
        }

        return $array;
    }
}