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

use Acme\SortedLinkedList\IntAbstractSortedLinkedList;

$list = IntAbstractSortedLinkedList::create(); // ascending
$list->addNode(5);
$list->addNode(1);
$list->addNode(4);

var_dump($list->toArray());
// [1, 4, 5]
```

```php
<?php

use Acme\SortedLinkedList\StringAbstractSortedLinkedList;

$list = StringAbstractSortedLinkedList::create(desc: true); // descending
$list->addNode('apple');
$list->addNode('orange');
$list->addNode('banana');

var_dump($list->toArray());
// ['orange', 'banana', 'apple']
```

## Run Tests

```bash
./vendor/bin/phpunit tests
```


---

Created in collaboration with Codex 🤖
