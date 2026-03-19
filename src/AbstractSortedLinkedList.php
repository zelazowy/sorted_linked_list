<?php

namespace Acme\SortedLinkedList;

use Acme\SortedLinkedList\Exception\InvalidListTypeException;

abstract class AbstractSortedLinkedList
{
    private ?Node $head = null;

    public static function create(bool $desc = false): static
    {
        return new static($desc);
    }

    private function __construct(private readonly bool $desc = false)
    {
    }

    public function addNode(mixed $data): void
    {
        $new = Node::create($data, null);

        if ($this->head === null) {
            $this->head = $new;
            return;
        }

        // check if a new item should be first
        // !! notice reversed order for comparison
        if ($this->compare($new->data, $this->head->data)) {
            $new->next = $this->head;
            $this->head = $new;
            return;
        }

        $current = $this->head;

        // find the right place to insert
        while ($current->next !== null && $this->compare($current->next->data, $new->data)) {
            $current = $current->next;
        }

        // update pointers
        $new->next = $current->next;
        $current->next = $new;
    }

    public function removeNode(mixed $data): void
    {
        if ($this->head === null) {
            return;
        }

        if ($this->head->data === $data) {
            $this->head = $this->head->next;
        }

        $current = $this->head;
        while ($current !== null && $current->next !== null && $this->compare($current->next->data, $data)) {
            if ($current->next->data === $data) {
                $current->next = $current->next->next;

                // remove only one node for duplicates
                break;
            }
            $current = $current->next;
        }
    }

    public function reverse(): static
    {
        $reversedList = new static(!$this->desc);
        $current = $this->head;
        while ($current !== null) {
            $reversedList->addNode($current->data);
            $current = $current->next;
        }
        return $reversedList;
    }

    public function mergeWith(self $listToMerge): static
    {
        if ($listToMerge::class !== static::class) {
            throw InvalidListTypeException::withExpected(static::class, $listToMerge::class);
        }

        $toAdd = $listToMerge->head;
        while ($toAdd !== null) {
            $this->addNode($toAdd->data);
            $toAdd = $toAdd->next;
        }

        return $this;
    }

    public function toArray(): array
    {
        if ($this->head === null) {
            return [];
        }

        $result = [];
        $current = $this->head;
        while ($current !== null) {
            $result[] = $current->data;
            $current = $current->next;
        }
        return $result;
    }

    public function compare(mixed $left, mixed $right): bool
    {
        if ($this->desc) {
            return $left >= $right;
        }

        return $left <= $right;
    }
}