<?php

namespace Acme\SortedLinkedList\Exception;

use InvalidArgumentException;

class InvalidListTypeException extends InvalidArgumentException
{
    public static function withExpected(string $got, string $expectedType): self
    {
        return new self("Invalid list type: expected {$expectedType}, got {$got}");
    }
}