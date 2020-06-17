<?php

namespace App\Helpers\Interfaces;

/**
 * Interface RowInterface
 * @package Interfaces
 */
interface RowInterface
{
    /**
     * @param PlaceInterface $place
     * @return self
     */
    public function addPlace(PlaceInterface $place): self;

    /**
     * @param PlaceInterface $place
     * @return void
     */
    public function removePlace(PlaceInterface $place): void;
}
