<?php

namespace App\Tests\App\Entity;

use App\Entity\CollectionEntity;
use PHPUnit\Framework\TestCase;

class CollectionEntityTest extends TestCase
{
    public function testEntityProperties(): void
    {
        $entity = new CollectionEntity('Apple', 'fruit', 500);

        $this->assertEquals('Apple', $entity->getName());
        $this->assertEquals('fruit', $entity->getType());
        $this->assertEquals(500, $entity->getQuantity());
    }

    public function testUnitConversion(): void
    {
        $entity = new CollectionEntity('Carrot', 'vegetable', 1000);

        $this->assertEquals(1.0, $entity->convertToKilograms());
        $this->assertEquals(1000, $entity->convertToGrams());
    }

    public function testSetQuantity(): void
    {
        $entity = new CollectionEntity('Banana', 'fruit', 300);
        $entity->setQuantity(600);

        $this->assertEquals(600, $entity->getQuantity());
    }
}
