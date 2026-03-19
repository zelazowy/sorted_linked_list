<?php

namespace Acme\SortedLinkedList;

use Acme\SortedLinkedList\Exception\InvalidNodeTypeException;
use InvalidArgumentException;

class StringSortedLinkedList extends SortedLinkedList
{
    public function addNode(mixed $data): void
    {
        if (!is_string($data)) {
            throw InvalidNodeTypeException::for($data, 'string');
        }

        parent::addNode($data);
    }
}
