<?php

namespace App\Entity;

class CollectionEntity
{
    private string $name;
    private string $type;
    private int $quantity;

    public function __construct(string $name, string $type, int $quantity)
    {
        $this->name = $name;
        $this->type = $type;
        $this->quantity = $quantity;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function convertToKilograms(): float
    {
        return $this->quantity / 1000;
    }

    public function convertToGrams(): int
    {
        return $this->quantity;
    }
}

