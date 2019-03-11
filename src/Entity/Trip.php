<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TripRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Trip
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $departure;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $arrival;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\Date()
     */
    private $departureDate;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\Date()
     */
    private $returnDate;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(
     *      min = 100,
     *      minMessage = "La description détaillée de ton voyage ne peut pas faire moins de 100 caractères."
     * )
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(
     *      min = 2,
     *      max = 6,
     *      minMessage = "Le nombre de personnes ne peut être inférieur à 2",
     *      maxMessage = "Le nombre de personnes ne peut excéder 6"
     * )
     */
    private $numberPersons;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Assert\Url()
     */
    private $coverImage;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", cascade={"persist"},   inversedBy="trips")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="trips")
     * @ORM\JoinColumn(nullable=false)
     */
    private $traveller;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TripBooking", mappedBy="trip", orphanRemoval=true)
     */
    private $tripBookings;

    /**
     * @ORM\Column(type="time")
     * @Assert\Time
     * @var string A "H:i" formatted value
     */
    private $tripHour;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $BookingNumber = 0;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TripComment", mappedBy="trip", orphanRemoval=true)
     */
    private $tripComments;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDeparture(): ?string
    {
        return $this->departure;
    }

    public function setDeparture(string $departure): self
    {
        $this->departure = $departure;

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

    public function getDepartureDate(): ?\DateTimeInterface
    {
        return $this->departureDate;
    }

    public function setDepartureDate(\DateTimeInterface $departureDate): self
    {
        $this->departureDate = $departureDate;

        return $this;
    }

    public function getReturnDate(): ?\DateTimeInterface
    {
        return $this->returnDate;
    }

    public function setReturnDate(\DateTimeInterface $returnDate): self
    {
        $this->returnDate = $returnDate;

        return $this;
    }


    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getNumberPersons(): ?int
    {
        return $this->numberPersons;
    }

    public function setNumberPersons(int $numberPersons): self
    {
        $this->numberPersons = $numberPersons;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

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

    public function getCoverImage(): ?string
    {
        return $this->coverImage;
    }

    public function setCoverImage(string $coverImage): self
    {
        $this->coverImage = $coverImage;

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

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->tripBookings = new ArrayCollection();
        $this->tripComments = new ArrayCollection();
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Allows to initialize automatically the slug
     * @ORM\PrePersist
     * @ORM\PreUpdate
     * 
     * @return void
     */
    public function initializeSlug()
        {
            if(empty($this->slug))
            {
                $slugify = new Slugify;
                $this->slug = $slugify->slugify($this->departure.'-'.$this->arrival);
            }
        }

    public function getTraveller(): ?User
    {
        return $this->traveller;
    }

    public function setTraveller(?User $traveller): self
    {
        $this->traveller = $traveller;

        return $this;
    }

    /**
     * @return Collection|TripBooking[]
     */
    public function getTripBookings(): Collection
    {
        return $this->tripBookings;
    }

    public function addTripBooking(TripBooking $tripBooking): self
    {
        if (!$this->tripBookings->contains($tripBooking)) {
            $this->tripBookings[] = $tripBooking;
            $tripBooking->setTrip($this);
        }

        return $this;
    }

    public function removeTripBooking(TripBooking $tripBooking): self
    {
        if ($this->tripBookings->contains($tripBooking)) {
            $this->tripBookings->removeElement($tripBooking);
            // set the owning side to null (unless already changed)
            if ($tripBooking->getTrip() === $this) {
                $tripBooking->setTrip(null);
            }
        }

        return $this;
    }

    public function getTripHour(): ?\DateTimeInterface
    {
        return $this->tripHour;
    }

    public function setTripHour(\DateTimeInterface $tripHour): self
    {
        $this->tripHour = $tripHour;

        return $this;
    }

    public function getBookingNumber(): ?int
    {
        return $this->BookingNumber;
    }

    public function setBookingNumber(?int $BookingNumber): self
    {
        $this->BookingNumber = $BookingNumber;

        return $this;
    }

    public function increaseBookingsNumber()
    {
      foreach($this->tripBookings as $tripBooking)
       { 
    
            return $this->BookingNumber += $tripBooking->getNumberPlaces();
       }           
    }

     public function decreaseBookingsNumber()
     {
        foreach($this->tripBookings as $tripBooking)
        {
            
        }
     }

     /**
      * @return Collection|TripComment[]
      */
     public function getTripComments(): Collection
     {
         return $this->tripComments;
     }

     public function addTripComment(TripComment $tripComment): self
     {
         if (!$this->tripComments->contains($tripComment)) {
             $this->tripComments[] = $tripComment;
             $tripComment->setTrip($this);
         }

         return $this;
     }

     public function removeTripComment(TripComment $tripComment): self
     {
         if ($this->tripComments->contains($tripComment)) {
             $this->tripComments->removeElement($tripComment);
             // set the owning side to null (unless already changed)
             if ($tripComment->getTrip() === $this) {
                 $tripComment->setTrip(null);
             }
         }

         return $this;
     }
    

}