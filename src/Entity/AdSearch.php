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


}