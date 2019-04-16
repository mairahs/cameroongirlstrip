<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class TripSearch
{
    /**
     * @var object|null
     * @Assert\Date()
     */
    private $departureDate;

    /**
     * @var string|null
     */
    private $arrival;

     /**
     * @var int|null
     */
    private $price;

    public function getDepartureDate(): ?\DateTimeInterface
    {
        return $this->departureDate;
    }

    public function setDepartureDate(?\DateTimeInterface $departureDate): self
    {
        $this->departureDate = $departureDate;

        return $this;
    }

    public function getArrival(): ?string
    {
        return $this->arrival;
    }

    public function setArrival(string $arrival): self
    {
        $this->arrival = $arrival;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

}