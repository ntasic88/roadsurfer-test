<?php
namespace App\Service;

use App\Storage\StorageEngineInterface;

class CollectionManager
{
    private StorageEngineInterface $storage;

    public function __construct(StorageEngineInterface $storage)
    {
        $this->storage = $storage;
    }

    public function process(array $items): void
    {
        foreach ($items as $item) {
            $this->storage->save($item['name'], $item);
        }
    }

    public function getCollection(string $type): array
    {
        $allItems = $this->storage->loadAll();
        return array_filter($allItems, fn($item) => $item['type'] === $type);
    }

    public function search(string $keyword, string $type): array
    {
        $allItems = $this->getCollection($type);
        return array_filter(
            $allItems,
            fn($item) => stripos($item['name'], $keyword) !== false
        );
    }

    public function delete(string $name): void
    {
        $this->storage->delete($name);
    }
}
