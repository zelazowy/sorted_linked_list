<?php

namespace Acme\SortedLinkedList;

use Acme\SortedLinkedList\Exception\InvalidNodeTypeException;
use InvalidArgumentException;

class IntAbstractSortedLinkedList extends AbstractSortedLinkedList
{
    public function addNode(mixed $data): void
    {
        if (!is_int($data)) {
            throw InvalidNodeTypeException::for($data, 'int');
        }

        parent::addNode($data);
    }
}