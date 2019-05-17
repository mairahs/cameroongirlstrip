<?php

namespace App\Entity;

use App\Entity\User;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TripRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Vich\Uploadable
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
     * @Assert\Image(
     *     mimeTypes = "image/jpeg"
     * )
     * @Vich\UploadableField(mapping="trip_image", fileNameProperty="fileName")
     * @var File|null
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string|null
     */
    private $fileName;

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

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(
     *      min = 2,
     *      max = 5,
     *      minMessage = "Le nombre de personne ne peut être inférieur à 2",
     *      maxMessage = "Le nombre de personne ne peut excéder 5"
     * )
     */
    private $fixedNumberPersons;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\TripOption", inversedBy="trips")
     */
    private $tripOptions;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\Column(type="float", scale=4, precision=6)
     */
    private $lat;

    /**
     * @ORM\Column(type="float", scale=4, precision=7)
     */
    private $lng;

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
        $this->tripOptions = new ArrayCollection();
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

    /**
     * Allows to initialize automatically the numberPersons
     * @ORM\PrePersist
     * 
     * @return void
     */
    public function initializeNumberPersons()
    {
        if(empty($this->numberPersons))
        {
            $this->numberPersons = $this->fixedNumberPersons;
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

    /**
     * Provide an author's comment for an trip
     *
     * @param  User $author
     *
     * @return Comment|null
     */
    public function getCommentFromAuthor(User $author)
    {
        foreach($this->tripComments as $tripComment )
        {
            if($tripComment->getAuthor() == $author)
            {
                return $tripComment;
            }    
        }
        return null;
    }

    /**
     * provide average rating for an ad
     *
     * @return float
     */
    public function getAvgRatings()
    {
        $sum = array_reduce($this->tripComments->toArray(), function($total, $tripComment){
            return $total + $tripComment->getRating();
        }, 0);

        if(count($this->tripComments) > 0)
        {
            return $sum / count($this->tripComments);
        }else{
            return 0;
        }
    }

    public function increaseBookingNumber()
    {
         $this->BookingNumber = array_reduce($this->tripBookings->toArray(), function($total, $tripBooking){
            return $total + $tripBooking->getNumberPlaces();
        }, 0);

        return $this->BookingNumber;
    }

    public function decreaseBookingNumber()
    {
         $this->BookingNumber = array_reduce($this->tripBookings->toArray(), function($minus, $tripBooking){
            return $this->BookingNumber - $tripBooking->getNumberPlaces();
        });

        return $this->BookingNumber;
    }

    public function decreaseNumberPersons()
    {
         $this->numberPersons = array_reduce($this->tripBookings->toArray(), function($minus, $tripBooking){
            return $minus - $tripBooking->getNumberPlaces();
        }, $this->fixedNumberPersons);

        return $this->numberPersons;
    }

    public function increaseNumberPersons()
    {  
        $this->numberPersons = array_reduce($this->tripBookings->toArray(), function($total, $tripBooking){
            return $this->numberPersons + $tripBooking->getNumberPlaces();
        });

        return $this->numberPersons;
    }

    public function getFixedNumberPersons(): ?int
    {
        return $this->fixedNumberPersons;
    }

    public function setFixedNumberPersons(int $fixedNumberPersons): self
    {
        $this->fixedNumberPersons = $fixedNumberPersons;

        return $this;
    }

    /**
     * @return Collection|TripOption[]
     */
    public function getTripOptions(): Collection
    {
        return $this->tripOptions;
    }

    public function addTripOption(TripOption $tripOption): self
    {
        if (!$this->tripOptions->contains($tripOption)) {
            $this->tripOptions[] = $tripOption;
            $tripOption->addTrip($this);
        }

        return $this;
    }

    public function removeTripOption(TripOption $tripOption): self
    {
        if ($this->tripOptions->contains($tripOption)) {
            $this->tripOptions->removeElement($tripOption);
            $tripOption->removeTrip($this);
        }

        return $this;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageFile(?file $imageFile): self
    {
        $this->imageFile = $imageFile;
        
        if ($this->imageFile instanceof UploadedFile)
         {
            $this->updated_at = new \DateTime('now');
        }

        return $this;
    } 

    public function getFileName(): ?String
    {
        return $this->fileName;
    }

    public function setFileName(?string $fileName): self
    {
        $this->fileName = $fileName;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
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