# Sorted Linked List

A small PHP library with a simple sorted linked list implementation.

It supports:
- `int` data via `IntSortedLinkedList`
- `string` data via `StringSortedLinkedList`
- ascending and descending order

Each list is type-specific (use either int list or string list).

## Install

```bash
composer install
```

## Usage

```php
<?php

use Acme\SortedLinkedList\IntSortedLinkedList;

$list = IntSortedLinkedList::create(); // ascending
$list->addNode(5);
$list->addNode(1);
$list->addNode(4);

var_dump($list->toArray());
// [1, 4, 5]
```

```php
<?php

use Acme\SortedLinkedList\StringSortedLinkedList;

$list = StringSortedLinkedList::create(desc: true); // descending
$list->addNode('apple');
$list->addNode('orange');
$list->addNode('banana');

var_dump($list->toArray());
// ['orange', 'banana', 'apple']
```

## Available Methods

- `addNode(int|string $data): void`
- `removeNode(int|string $data): void` (removes first matching node)
- `toArray(): array`
- `reverse(): static` (returns a new list with opposite order)
- `mergeWith(self $listToMerge): static` (merges and keeps sorting)

```php
<?php

use Acme\SortedLinkedList\IntSortedLinkedList;

$list = IntSortedLinkedList::create();
$list->addNode(3);
$list->addNode(1);
$list->addNode(2);
$list->removeNode(2);

$reversed = $list->reverse();

$other = IntSortedLinkedList::create();
$other->addNode(7);
$other->addNode(0);

$merged = $list->mergeWith($other);

var_dump($list->toArray());     // [0, 1, 3, 7]
var_dump($reversed->toArray()); // [3, 1]
var_dump($merged->toArray());   // [0, 1, 3, 7]
```

## Run Tests

```bash
./vendor/bin/phpunit tests
```


---

Created in collaboration with Codex 🤖
