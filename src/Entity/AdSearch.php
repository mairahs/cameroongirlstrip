<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

class AdSearch
{

    /**
     * @var string|null
     */
    private $location;

    /**
     * @var int|null
     */
    private $price;

    /**
     * @var int|null
     */
    private $rooms;

    /**
     * @var ArrayCollection
     */
    private $adOptions;

    /**
     * @var float|null
     */
    private $lat;

    /**
     * @var float|null
     */
    private $lng;

    public function __construct()
    {
        $this->adOptions = new ArrayCollection();
    }


    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

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

    public function getRooms(): ?int
    {
        return $this->rooms;
    }

    public function setRooms(int $rooms): self
    {
        $this->rooms = $rooms;

        return $this;
    }

    /**
     * @return ArrayCollection $adOptions
    */
    public function getAdOptions(): ArrayCollection
    {
        return $this->adOptions;
    }

    /**
     * @param ArrayCollection $adOptions
     */
    public function setAdOptions(ArrayCollection $adOptions): void
    {
        $this->adOptions = $adOptions;
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