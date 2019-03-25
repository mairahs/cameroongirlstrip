<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TripBookingRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class TripBooking
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $numberPlaces;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="tripBookings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tripBooker;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Trip", inversedBy="tripBookings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $trip;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumberPlaces(): ?int
    {
        return $this->numberPlaces;
    }

    public function setNumberPlaces(int $numberPlaces): self
    {
        $this->numberPlaces = $numberPlaces;

        return $this;
    }

    public function getTripBooker(): ?User
    {
        return $this->tripBooker;
    }

    public function setTripBooker(?User $tripBooker): self
    {
        $this->tripBooker = $tripBooker;

        return $this;
    }

    public function getTrip(): ?Trip
    {
        return $this->trip;
    }

    public function setTrip(?Trip $trip): self
    {
        $this->trip = $trip;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * 
     * Used to automatically generate some info before the insertion of booking in database
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function prePersist()
    {
        if(empty($this->createdAt))
        {
            $this->createdAt = new \DateTime();
        }

        if(empty($this->amount))
        {
            $this->amount = $this->trip->getPrice();
        }
    }

    /**
     * 
     * Used to automatically generate some info after the insertion of booking in database
     * @ORM\PostPersist
     */
    public function increaseTripBooking()
    {
        foreach($this->trip->getTripBookings() as $tripBooking)
        {
            $tripBooking->setNumberPlaces($tripBooking->numberPlaces++);
        }

        $this->trip->setBookingNumber($this->trip->increaseBookingNumber());
        $this->trip->setNumberPersons($this->trip->decreaseNumberPersons());

        $this->manager->persist($this->trip);
        $this->manager->flush(); 
    }
    
     /**
     * 
     * Used to automatically generate some info after the suppression of booking in database
     * @ORM\PreRemove
     */
    public function decreaseTripBooking()
    {
        foreach($this->trip->getTripBookings() as $tripBooking)
        {
            $tripBooking->setNumberPlaces($tripBooking->numberPlaces--);
        }

        $this->trip->setBookingNumber($this->trip->decreaseBookingNumber());
        $this->trip->setNumberPersons($this->trip->increaseNumberPersons());
    }   
}
