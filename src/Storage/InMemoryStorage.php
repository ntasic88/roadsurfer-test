<?php

namespace App\Storage;

class InMemoryStorage implements StorageEngineInterface
{
    private array $storage = [];

    public function __construct(string $filePath)
    {
        if (file_exists($filePath)) {
            $fileContents = file_get_contents($filePath);
            $data = json_decode($fileContents, true);

            if (is_array($data)) {
                foreach ($data as $item) {
                    $this->save($item['name'], $item);
                }
            }
        }
    }

    public function save(string $key, array $data): void
    {
        $this->storage[$key] = $data;
    }

    public function load(string $key): array
    {
        return $this->storage[$key] ?? [];
    }

    public function loadAll(): array
    {
        return $this->storage;
    }

    public function delete(string $key): void
    {
        unset($this->storage[$key]);
    }
}

