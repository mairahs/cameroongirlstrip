<?php

namespace App\Entity;

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


}