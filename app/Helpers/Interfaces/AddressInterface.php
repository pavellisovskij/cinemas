<?php

namespace App\Helpers\Interfaces;

/**
 * Interface AddressInterface
 * @package Interfaces
 */
interface AddressInterface
{
    /**
     * @return string
     */
    public function getLongitude(): string;

    /**
     * @return string
     */
    public function getLatitude(): string;

    /**
     * @return string
     */
    public function getStreet(): string;

    /**
     * @return string
     */
    public function getPhone(): ?string;

    /**
     * @return string
     */
    public function getCity(): string;

    /**
     * @return string
     */
    public function getCountry(): string;
}
