<?php

namespace App\Entity;

use App\Entity\User;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AdRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(
 * fields={"title"}, message="Une autre annonce possède déjà le même titre. Meri de rectifier STP.")
 */
class Ad
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *  * @Assert\Length(
     *      min = 10,
     *      max = 255,
     *      minMessage = "Le titre de ton annonce doit faire au moins 1O caractères.",
     *      maxMessage = "Le titre de ton annonce ne peut pas dépasser 255 caractères."
     * )
     */
    private $title;

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
     *  @Assert\Length(
     *      min = 20,
     *      minMessage = "Ton introduction doit faire au moins 2O caractères."
     * )
     */
    private $introduction;

    /**
     * @ORM\Column(type="text")
     *  @Assert\Length(
     *      min = 100,
     *      minMessage = "La description détaillée de ton annonce ne peut pas faire moins de 100 caractères."
     * )
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Url()
     */
    private $coverImage;

    /**
     * @ORM\Column(type="integer")
     */
    private $rooms;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $location;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Image", mappedBy="ad", orphanRemoval=true, cascade={"persist"})
     *  @Assert\Valid()
     */
    private $images;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="ads")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AdBooking", mappedBy="ad", orphanRemoval=true)
     */
    private $adBookings;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AdComment", mappedBy="ad", orphanRemoval=true)
     */
    private $adComments;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\AdOption", inversedBy="ads")
     */
    private $adOptions;
    
    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->adBookings = new ArrayCollection();
        $this->adComments = new ArrayCollection();
        $this->adOptions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function getIntroduction(): ?string
    {
        return $this->introduction;
    }

    public function setIntroduction(string $introduction): self
    {
        $this->introduction = $introduction;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

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
            $this->slug = $slugify->slugify($this->title);
        }
    }

    /**
     * @return Collection|Image[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setAd($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getAd() === $this) {
                $image->setAd(null);
            }
        }

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return Collection|AdBooking[]
     */
    public function getAdBookings(): Collection
    {
        return $this->adBookings;
    }

    public function addAdBooking(AdBooking $adBooking): self
    {
        if (!$this->adBookings->contains($adBooking)) {
            $this->adBookings[] = $adBooking;
            $adBooking->setAd($this);
        }

        return $this;
    }

    public function removeAdBooking(AdBooking $adBooking): self
    {
        if ($this->adBookings->contains($adBooking)) {
            $this->adBookings->removeElement($adBooking);
            // set the owning side to null (unless already changed)
            if ($adBooking->getAd() === $this) {
                $adBooking->setAd(null);
            }
        }

        return $this;
    }

    /**
     * avoid to obtain an array which contains not avalaible day for this ad
     *
     * @return \DateTime []
     */
    public function getNotAvailableDays()
    {
        $notAvailableDays = [];

        foreach($this->adBookings as $booking)
        {
            $result = range($booking->getStartDate()->getTimestamp(), $booking->getEndDate()->getTimestamp(), 24*60*60);
            $days = array_map(function($dayTimestamp){
                return new \DateTime(date('Y-m-d', $dayTimestamp));
            }, $result);

            $notAvailableDays = array_merge($notAvailableDays, $days);
        }

        return $notAvailableDays;     
    }

    /**
     * @return Collection|AdComment[]
     */
    public function getAdComments(): Collection
    {
        return $this->adComments;
    }

    public function addAdComment(AdComment $adComment): self
    {
        if (!$this->adComments->contains($adComment)) {
            $this->adComments[] = $adComment;
            $adComment->setAd($this);
        }

        return $this;
    }

    public function removeAdComment(AdComment $adComment): self
    {
        if ($this->adComments->contains($adComment)) {
            $this->adComments->removeElement($adComment);
            // set the owning side to null (unless already changed)
            if ($adComment->getAd() === $this) {
                $adComment->setAd(null);
            }
        }

        return $this;
    }

    /**
     * Provide an author's comment for an ad
     *
     * @param  User $author
     *
     * @return Comment|null
     */
    public function getCommentFromAuthor(User $author)
    {
        foreach($this->adComments as $adComment )
        {
            if($adComment->getAuthor() == $author)
            {
                return $adComment;
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
        $sum = array_reduce($this->adComments->toArray(), function($total, $adComment){
            return $total + $adComment->getRating();
        }, 0);

        if(count($this->adComments) > 0)
        {
            return $sum / count($this->adComments);
        }else{
            return 0;
        }
    }

    /**
     * @return Collection|AdOption[]
     */
    public function getAdOptions(): Collection
    {
        return $this->adOptions;
    }

    public function addAdOption(AdOption $adOption): self
    {
        if (!$this->adOptions->contains($adOption)) {
            $this->adOptions[] = $adOption;
            $adOption->addAd($this);
        }

        return $this;
    }

    public function removeAdOption(AdOption $adOption): self
    {
        if ($this->adOptions->contains($adOption)) {
            $this->adOptions->removeElement($adOption);
            $adOption->removeAd($this);
        }

        return $this;
    }

   
}
