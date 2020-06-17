<?php

namespace App\Helpers\Interfaces;

/**
 * Interface FilmInterface
 * @package Interfaces
 */
interface FilmInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return \DateInterval
     */
    public function getInterval(): \DateInterval;

    /**
     * @return \DateTime
     */
    public function getDateStart(): \DateTime;
}
