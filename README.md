# Iterator Tools
Composer Package: `mamazu/iterator-tools`

Requirements: PHP 7+

CI: [![Build Status](https://travis-ci.com/mamazu/iterator-tools.svg?branch=master)](https://travis-ci.com/mamazu/iterator-tools)

A small list of functions that help when dealing with iterators in php.

## How to use
First: include the `autoload.php` file.

If you like the object oriented style use it that way:
```php
$tool = new IteratorTools();
$tool->iterator_map($iterator, function ($a) { return $a + 1}; );
```

If you like the procedural style:
```php
IteratorTools::iterator_map($iterator, function ($a) { return $a + 1; });
```