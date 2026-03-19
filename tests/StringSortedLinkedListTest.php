<?php

namespace Acme\Tests;

use Acme\SortedLinkedList\Exception\InvalidNodeTypeException;
use Acme\SortedLinkedList\StringSortedLinkedList;
use PHPUnit\Framework\TestCase;

class StringSortedLinkedListTest extends TestCase
{
    private StringSortedLinkedList $list;

    public function testAddingSingleNode(): void
    {
        $this->givenEmptyList();
        $this->whenAddingNode('smth');
        $this->thenExpectListArrayOutput(['smth']);
    }

    public function testAddBetween(): void
    {
        $this->givenEmptyList();
        $this->whenAddingNode('apple');
        $this->whenAddingNode('orange');
        $this->whenAddingNode('banana');
        $this->whenAddingNode('grape');
        $this->whenAddingNode('avocado');
        $this->thenExpectListArrayOutput(['apple', 'avocado', 'banana', 'grape', 'orange']);
    }

    public function testSameData(): void
    {
        $this->givenEmptyList();
        $this->whenAddingNode('apple');
        $this->whenAddingNode('orange');
        $this->whenAddingNode('apple');
        $this->whenAddingNode('orange');
        $this->thenExpectListArrayOutput(['apple', 'apple', 'orange', 'orange']);
    }

    public function testAddAsFirst(): void
    {
        $this->givenEmptyList();
        $this->whenAddingNode('banana');
        $this->whenAddingNode('apple');
        $this->whenAddingNode('apricot');
        $this->thenExpectListArrayOutput(['apple', 'apricot', 'banana']);
    }

    public function testAddLast(): void
    {
        $this->givenEmptyList();
        $this->whenAddingNode('apple');
        $this->whenAddingNode('banana');
        $this->whenAddingNode('cherry');
        $this->thenExpectListArrayOutput(['apple', 'banana', 'cherry']);
    }

    public function testPolish(): void
    {
        $this->givenEmptyList();
        $this->whenAddingNode('żółć');
        $this->whenAddingNode('złoto');
        $this->whenAddingNode('ząb');
        $this->whenAddingNode('źrebak');
        $this->thenExpectListArrayOutput(['ząb', 'złoto', 'źrebak', 'żółć']);
    }

    // just for fun, how to even sort emojis? 🙃
    public function testEmoji(): void
    {
        $this->givenEmptyList();
        $this->whenAddingNode('😀');
        $this->whenAddingNode('😂');
        $this->whenAddingNode('😁');
        $this->whenAddingNode('😇');
        $this->thenExpectListArrayOutput(['😀', '😁', '😂', '😇']);
    }

    public function testDescOrder(): void
    {
        $this->givenDescOrderedEmptyList();
        $this->whenAddingNode('apple');
        $this->whenAddingNode('orange');
        $this->whenAddingNode('banana');
        $this->whenAddingNode('grape');
        $this->whenAddingNode('avocado');
        $this->whenAddingNode('grape');
        $this->thenExpectListArrayOutput(['orange', 'grape', 'grape', 'banana', 'avocado', 'apple']);
    }

    public function testAddingIncompatibleData(): void
    {
        $this->givenEmptyList();
        $this->whenAddingNode('apple');
        $this->thenExpectInvalidArgumentException();
        $this->whenAddingIncompatibleNode(67);
    }

    public function testRemoving(): void
    {
        $this->givenEmptyList();
        $this->whenAddingNode('apple');
        $this->whenAddingNode('orange');
        $this->whenAddingNode('banana');
        $this->whenAddingNode('grape');
        $this->whenAddingNode('avocado');
        $this->whenAddingNode('grape');
        $this->whenRemovingNode('grape');
        $this->thenExpectListArrayOutput(['apple', 'avocado', 'banana', 'grape', 'orange']);
    }

    public function testRemovingFromEmptyList(): void
    {
        $this->givenEmptyList();
        $this->whenRemovingNode('grape');
        $this->thenExpectListArrayOutput([]);
    }

    public function testRemovingNonExistingNode(): void
    {
        $this->givenEmptyList();
        $this->whenAddingNode('apple');
        $this->whenRemovingNode('grape');
        $this->thenExpectListArrayOutput(['apple']);
    }

    public function testReversing(): void
    {
        $this->givenEmptyList();
        $this->whenAddingNode('apple');
        $this->whenAddingNode('orange');
        $this->whenAddingNode('banana');
        $this->whenAddingNode('grape');
        $this->whenAddingNode('avocado');
        $this->whenAddingNode('grape');
        $this->whenReversed();
        $this->thenExpectListArrayOutput(['orange', 'grape', 'grape', 'banana', 'avocado', 'apple']);
    }

    private function givenEmptyList(): void
    {
        $this->list = StringSortedLinkedList::create();
    }

    private function givenDescOrderedEmptyList(): void
    {
        $this->list = StringSortedLinkedList::create(desc: true);
    }

    private function whenAddingNode(string $data): void
    {
        $this->list->addNode($data);
    }

    private function whenRemovingNode(string $string): void
    {
        $this->list->removeNode($string);
    }

    private function whenAddingIncompatibleNode(int $data): void
    {
        $this->list->addNode($data);
    }

    public function whenReversed(): void
    {
        $this->list = $this->list->reverse();
    }

    private function thenExpectListArrayOutput(array $expected): void
    {
        $this->assertEquals($expected, $this->list->toArray());
    }

    private function thenExpectInvalidArgumentException(): void
    {
        $this->expectException(InvalidNodeTypeException::class);
        $this->expectExceptionMessage('Invalid node type: expected string, got int');
    }
}
