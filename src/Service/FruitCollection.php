<?php

namespace App\Service;

use App\Entity\CollectionEntity;

class FruitCollection implements CollectionInterface
{
    private array $items = [];

    public function add(CollectionEntity $item): void
    {
        $this->items[$item->getName()] = $item;
    }

    public function remove(string $name): void
    {
        unset($this->items[$name]);
    }

    public function list(): array
    {
        return $this->items;
    }

    public function search(string $keyword): array
    {
        return array_filter($this->items, fn($item) => str_contains($item->getName(), $keyword));
    }
}

