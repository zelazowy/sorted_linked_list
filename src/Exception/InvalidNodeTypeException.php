<?php

namespace Acme\SortedLinkedList\Exception;

use InvalidArgumentException;

class InvalidNodeTypeException extends InvalidArgumentException
{
    public static function for(mixed $data, string $expectedType): self
    {
        return new self("Invalid node type: expected {$expectedType}, got " . gettype($data));
    }
}