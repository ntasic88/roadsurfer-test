<?php

namespace App\Tests\App\Service;

use App\Storage\InMemoryStorage;
use App\Service\CollectionManager;
use PHPUnit\Framework\TestCase;

class CollectionManagerTest extends TestCase
{
    private string $testFilePath;

    protected function setUp(): void
    {
        $this->testFilePath = __DIR__ . '/test_request.json';
        file_put_contents($this->testFilePath, json_encode([]));
    }

    protected function tearDown(): void
    {
        if (file_exists($this->testFilePath)) {
            unlink($this->testFilePath);
        }
    }

    public function testProcessAndGetCollection(): void
    {
        $storage = new InMemoryStorage($this->testFilePath);
        $manager = new CollectionManager($storage);

        $items = [
            ['name' => 'Apples', 'type' => 'fruit', 'quantity' => 500],
            ['name' => 'Carrot', 'type' => 'vegetable', 'quantity' => 300],
        ];

        $manager->process($items);

        $fruits = $manager->getCollection('fruit');
        $this->assertCount(1, $fruits);
        $this->assertEquals(500, $fruits['Apples']['quantity']);

        $vegetables = $manager->getCollection('vegetable');
        $this->assertCount(1, $vegetables);
        $this->assertArrayHasKey('Carrot', $vegetables);
        $this->assertEquals(300, $vegetables['Carrot']['quantity']);
    }

    public function testStorageIntegration(): void
    {
        $sampleData = [
            ['name' => 'Banana', 'type' => 'fruit', 'quantity' => 700],
        ];
        file_put_contents($this->testFilePath, json_encode($sampleData));

        $storage = new InMemoryStorage($this->testFilePath);
        $manager = new CollectionManager($storage);

        $fruits = $manager->getCollection('fruit');
        $this->assertCount(1, $fruits);
        $this->assertArrayHasKey('Banana', $fruits);
        $this->assertEquals(700, $fruits['Banana']['quantity']);
    }

    public function testSearch(): void
    {
        $sampleData = [
            ['name' => 'Apples', 'type' => 'fruit', 'quantity' => 500],
            ['name' => 'Carrot', 'type' => 'vegetable', 'quantity' => 300],
            ['name' => 'Apricot', 'type' => 'fruit', 'quantity' => 400],
        ];
        file_put_contents($this->testFilePath, json_encode($sampleData));

        $storage = new InMemoryStorage($this->testFilePath);
        $manager = new CollectionManager($storage);

        $fruits = $manager->search('Apples', 'fruit');
        $this->assertCount(1, $fruits);
    }

    public function testDelete(): void
    {
        $storage = new InMemoryStorage($this->testFilePath);
        $manager = new CollectionManager($storage);

        $items = [
            ['name' => 'Apple', 'type' => 'fruit', 'quantity' => 500],
            ['name' => 'Carrot', 'type' => 'vegetable', 'quantity' => 300],
        ];
        $manager->process($items);

        $allItems = $storage->loadAll();
        $this->assertCount(2, $allItems);
        $this->assertArrayHasKey('Apple', $allItems);
        $this->assertArrayHasKey('Carrot', $allItems);

        $manager->delete('Apple');

        $allItems = $storage->loadAll();
        $this->assertCount(1, $allItems);
        $this->assertArrayNotHasKey('Apple', $allItems);
        $this->assertArrayHasKey('Carrot', $allItems);
    }
}
