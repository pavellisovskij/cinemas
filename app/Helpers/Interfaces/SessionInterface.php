<?php

namespace App\Helpers\Interfaces;

/**
 * Interface SessionInterface
 * @package Interfaces
 */
interface SessionInterface
{
    /**
     * @return FilmInterface
     */
    public function getFilm(): FilmInterface;

    /**
     * @return PlaceInterface[]
     */
    public function getFreePlaces(): array;

    /**
     * @param PlaceInterface $place
     * @return bool
     */
    public function billPlace(PlaceInterface $place): bool;
}
