<?php

namespace App\Tests\App\Service;

use App\Entity\CollectionEntity;
use App\Service\FruitCollection;
use PHPUnit\Framework\TestCase;

class FruitCollectionTest extends TestCase
{
    public function testAddAndList(): void
    {
        $collection = new FruitCollection();
        $entity = new CollectionEntity('Apple', 'fruit', 500);

        $collection->add($entity);
        $this->assertCount(1, $collection->list());
        $this->assertSame($entity, $collection->list()['Apple']);
    }

    public function testRemove(): void
    {
        $collection = new FruitCollection();
        $entity = new CollectionEntity('Orange', 'fruit', 300);

        $collection->add($entity);
        $this->assertCount(1, $collection->list());

        $collection->remove('Orange');
        $this->assertCount(0, $collection->list());
    }

    public function testSearch(): void
    {
        $collection = new FruitCollection();
        $entity1 = new CollectionEntity('Apple', 'fruit', 500);
        $entity2 = new CollectionEntity('Apricot', 'fruit', 400);

        $collection->add($entity1);
        $collection->add($entity2);

        $results = $collection->search('App');
        $this->assertCount(1, $results);
        $this->assertSame($entity1, $results['Apple']);
    }
}
