<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
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

    /**
     * @var float|null
     */
    private $lat;

    /**
     * @var float|null
     */
    private $lng;

    /**
     * @var ArrayCollection
     */
    private $tripOptions;

    public function __construct()
    {
        $this->tripOptions = new ArrayCollection();
    }

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

    /**
     * @return ArrayCollection $adOptions
    */
    public function getTripOptions(): ArrayCollection
    {
        return $this->tripOptions;
    }

    /**
     * @param ArrayCollection $adOptions
     */
    public function setTripOptions(ArrayCollection $tripOptions): void
    {
        $this->tripOptions = $tripOptions;
    }

    public function getLat(): ?float
    {
        return $this->lat;
    }

    public function setLat(float $lat): self
    {
        $this->lat = $lat;

        return $this;
    }

    public function getLng(): ?float
    {
        return $this->lng;
    }

    public function setLng(float $lng): self
    {
        $this->lng = $lng;

        return $this;
    }


}