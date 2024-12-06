<?php

namespace App\Service;

use App\Entity\CollectionEntity;

interface CollectionInterface
{
    public function add(CollectionEntity $item): void;

    public function remove(string $name): void;

    public function list(): array;

    public function search(string $keyword): array;
}
