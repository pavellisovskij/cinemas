<?php

namespace App\Helpers\Interfaces;

/**
 * Interface HallInterface
 */
interface HallInterface
{
    /**
     * @param RowInterface $place
     * @return self
     */
    public function addRow(RowInterface $place): self;

    /**
     * @param RowInterface $place
     * @return void
     */
    public function removeRow(RowInterface $place): void;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return int
     */
    public function getCountPlaces(): int;
}
