<?php

namespace App\Tests\App\Storage;

use App\Storage\InMemoryStorage;
use PHPUnit\Framework\TestCase;

class InMemoryStorageTest extends TestCase
{
    public function testInitializationFromJson(): void
    {
        $filePath = __DIR__ . '/test_request.json';
        file_put_contents($filePath, json_encode([
            ['name' => 'Carrot', 'type' => 'vegetable', 'quantity' => 10922],
            ['name' => 'Apple', 'type' => 'fruit', 'quantity' => 500]
        ]));

        $storage = new InMemoryStorage($filePath);

        $allItems = $storage->loadAll();

        $this->assertCount(2, $allItems);
        $this->assertArrayHasKey('Carrot', $allItems);
        $this->assertArrayHasKey('Apple', $allItems);

        unlink($filePath);
    }
}

