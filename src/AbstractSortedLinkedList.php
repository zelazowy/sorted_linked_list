<?php

namespace Acme\SortedLinkedList;

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
            return $left > $right;
        }

        return $left < $right;
    }
}