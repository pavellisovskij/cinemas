<?php

namespace App\Helpers\Interfaces;

/**
 * Interface CinemaInterface
 */
interface CinemaInterface
{
    /**
     * @param HallInterface $hall
     * @return self
     */
    public function addHall(HallInterface $hall): self;

    /**
     * @param HallInterface $hall
     * @return void
     */
    public function removeHall(HallInterface $hall): void;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getDescription(): string;

    /**
     * @return AddressInterface
     */
    public function getAddress(): AddressInterface;

    /**
     * @param SessionInterface $session
     * @param HallInterface $hall
     * @return self
     */
    public function addSession(SessionInterface $session, HallInterface $hall): self;

    /**
     * @param SessionInterface $session
     */
    public function removeSession(SessionInterface $session): void;

    /**
     * @return SessionInterface[]
     */
    public function getSessions(): array;
}
