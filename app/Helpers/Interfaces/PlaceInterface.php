<?php

namespace App\Helpers\Interfaces;

/**
 * Interface PlaceInterface
 */
interface PlaceInterface
{
    /**
     * @return array
     */
    public function getOptions(): ?array;

    /**
     * @return float
     */
    public function getPrice(): float;
}
