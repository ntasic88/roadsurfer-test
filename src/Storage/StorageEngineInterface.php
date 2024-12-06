<?php

namespace App\Storage;

interface StorageEngineInterface
{
    public function save(string $key, array $data): void;

    public function load(string $key): array;

    public function loadAll(): array;

    public function delete(string $key): void;
}
