# Iterator Tools
Composer Package: `mamazu/iterator-tools`

Requirements: PHP 7.2

CI: [![Build Status](https://travis-ci.com/mamazu/iterator-tools.svg?branch=master)](https://travis-ci.com/mamazu/iterator-tools)

A small list of functions that help when dealing with iterators in php.

## Available functions
All array functions are now also available for iterators
* `iterator_filter(iterable $iterable, callable $func): iterable`
* `iterator_map(iterable $iterable, callable $func): iterable`
* `iterator_reduce(iterable $iterable, callable $func, $startValue = null): mixed`
* `array_to_iterator(array $data): iterable`

Making non-iterator functions use iterators
* `file(string $fileName): iterable`
