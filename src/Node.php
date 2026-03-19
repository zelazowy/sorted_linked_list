<?php

namespace Acme\SortedLinkedList;

class Node
{
    public static function create(string|int $data, ?self $next): self
    {
        return new self($data, $next);
    }

    public function __construct(
        public readonly string|int $data,
        public ?self $next
    ) {
    }
}