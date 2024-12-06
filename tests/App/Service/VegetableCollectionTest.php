<?php

namespace App\Tests\App\Service;

use App\Entity\CollectionEntity;
use App\Service\VegetableCollection;
use PHPUnit\Framework\TestCase;

class VegetableCollectionTest extends TestCase
{
    public function testAddAndList(): void
    {
        $collection = new VegetableCollection();
        $entity = new CollectionEntity('Carrot', 'vegetable', 800);

        $collection->add($entity);
        $this->assertCount(1, $collection->list());
        $this->assertSame($entity, $collection->list()['Carrot']);
    }

    public function testRemove(): void
    {
        $collection = new VegetableCollection();
        $entity = new CollectionEntity('Spinach', 'vegetable', 200);

        $collection->add($entity);
        $this->assertCount(1, $collection->list());

        $collection->remove('Spinach');
        $this->assertCount(0, $collection->list());
    }

    public function testSearch(): void
    {
        $collection = new VegetableCollection();
        $entity1 = new CollectionEntity('Spinach', 'vegetable', 200);
        $entity2 = new CollectionEntity('Carrot', 'vegetable', 500);

        $collection->add($entity1);
        $collection->add($entity2);

        $results = $collection->search('Car');
        $this->assertCount(1, $results);
        $this->assertSame($entity2, $results['Carrot']);
    }
}

