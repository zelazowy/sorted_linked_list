<?php

namespace Acme\Tests;

use Acme\SortedLinkedList\Exception\InvalidNodeTypeException;
use Acme\SortedLinkedList\IntSortedLinkedList;
use PHPUnit\Framework\TestCase;

class IntSortedLinkedListTest extends TestCase
{
    private IntSortedLinkedList $list;
    private IntSortedLinkedList $newList;

    public function testAddingSingleItem(): void
    {
        $this->givenEmptyList();
        $this->whenAddingItem(1);
        $this->thenExpectListArrayOutput([1]);
    }

    public function testAddingCoupleItems(): void
    {
        $this->givenEmptyList();
        $this->whenAddingItem(1);
        $this->whenAddingItem(5);
        $this->whenAddingItem(4);
        $this->thenExpectListArrayOutput([1, 4, 5]);
    }

    public function testNegativeItems(): void
    {
        $this->givenEmptyList();
        $this->whenAddingItem(-1);
        $this->whenAddingItem(-5);
        $this->whenAddingItem(-4);
        $this->thenExpectListArrayOutput([-5, -4, -1]);
    }

    public function testIntegers(): void
    {
        $this->givenEmptyList();
        $this->whenAddingItem(1);
        $this->whenAddingItem(-2);
        $this->whenAddingItem(3);
        $this->whenAddingItem(4);
        $this->whenAddingItem(100000);
        $this->thenExpectListArrayOutput([-2, 1, 3, 4, 100000]);
    }

    public function testSameItems(): void
    {
        $this->givenEmptyList();
        $this->whenAddingItem(1);
        $this->whenAddingItem(1);
        $this->whenAddingItem(5);
        $this->whenAddingItem(1);
        $this->whenAddingItem(1);
        $this->thenExpectListArrayOutput([1, 1, 1, 1, 5]);
    }

    public function testAddingAsFirst(): void
    {
        $this->givenEmptyList();
        $this->whenAddingItem(1);
        $this->whenAddingItem(2);
        $this->whenAddingItem(3);
        $this->whenAddingItem(4);
        $this->thenExpectListArrayOutput([1, 2, 3, 4]);
        $this->whenAddingItem(0);
        $this->thenExpectListArrayOutput([0, 1, 2, 3, 4]);
    }

    public function testAddingIncompatibleData(): void
    {
        $this->givenEmptyList();
        $this->whenAddingItem(1);
        $this->thenExpectInvalidArgumentException();
        $this->whenAddingIncompatibleItem('banana');
    }

    public function testDescending(): void
    {
        $this->givenDescendingEmptyList();
        $this->whenAddingItem(1);
        $this->whenAddingItem(2);
        $this->whenAddingItem(-3);
        $this->whenAddingItem(4);
        $this->whenAddingItem(2);
        $this->thenExpectListArrayOutput([4, 2, 2, 1, -3]);
    }

    public function testRemoving(): void
    {
        $this->givenEmptyList();
        $this->whenAddingItem(1);
        $this->whenAddingItem(5);
        $this->whenAddingItem(4);
        $this->whenAddingItem(5);
        $this->whenRemovingItem(5);
        $this->thenExpectListArrayOutput([1, 4, 5]);
    }

    public function testRemovingFromEmptyList(): void
    {
        $this->givenEmptyList();
        $this->whenRemovingItem(5);
        $this->thenExpectListArrayOutput([]);
    }

    public function testRemovingNonExistingNode(): void
    {
        $this->givenEmptyList();
        $this->whenAddingItem(1);
        $this->whenRemovingItem(5);
        $this->thenExpectListArrayOutput([1]);
    }

    public function testReversing(): void
    {
        $this->givenEmptyList();
        $this->whenAddingItem(1);
        $this->whenAddingItem(5);
        $this->whenAddingItem(4);
        $this->whenAddingItem(3);
        $this->whenAddingItem(2);
        $this->whenAddingItem(4);
        $this->whenReversed();
        $this->thenExpectListArrayOutput([5, 4, 4, 3, 2, 1]);
    }

    public function testMerging(): void
    {
        $this->givenEmptyList();
        $this->whenAddingItem(1);
        $this->whenAddingItem(5);
        $this->whenAddingItem(4);
        $this->andGivenNewListWith([2, 9]);
        $this->whenMerging();
        $this->thenExpectListArrayOutput([1, 2, 4, 5, 9]);
    }

    private function givenEmptyList(): void
    {
        $this->list = IntSortedLinkedList::create();
    }

    private function givenDescendingEmptyList(): void
    {
        $this->list = IntSortedLinkedList::create(desc: true);
    }

    private function andGivenNewListWith(array $nodes): void
    {
        $this->newList = IntSortedLinkedList::create();
        foreach ($nodes as $node) {
            $this->newList->addNode($node);
        }
    }

    private function whenMerging(): void
    {
        $this->list = $this->list->mergeWith($this->newList);
    }

    private function whenAddingItem(int $data): void
    {
        $this->list->addNode($data);
    }

    private function whenAddingIncompatibleItem(string $data): void
    {
        $this->list->addNode($data);
    }

    private function whenRemovingItem(int $data): void
    {
        $this->list->removeNode($data);
    }

    private function whenReversed(): void
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
        $this->expectExceptionMessage('Invalid node type: expected int, got string');
    }
}
