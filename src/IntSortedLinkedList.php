<?php

namespace Acme\SortedLinkedList;

use Acme\SortedLinkedList\Exception\InvalidNodeTypeException;

class IntSortedLinkedList extends AbstractSortedLinkedList
{
    public function addNode(mixed $data): void
    {
        if (!is_int($data)) {
            throw InvalidNodeTypeException::for($data, 'int');
        }

        parent::addNode($data);
    }
}