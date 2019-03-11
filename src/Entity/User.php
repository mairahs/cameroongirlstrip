<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(
 * fields={"email"}, message="Une autre GirlTripeuse possède déjà le même email. Meri de rectifier STP.")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Renseigne ton prénom STP.")
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Assert\NotBlank(message="Renseigne ton nom de famille STP.")
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Assert\Email(message="Renseigne une adresse email valide STP.")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Url(message="Renseigne une url valide STP.")
     */
    private $picture;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $hash;

     /**
     * @Assert\EqualTo(propertyPath="hash", message="Les deux mots de passe ne sont pas identiques.")
     */
    public $passwordConfirm;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     * min = 10,
     * minMessage = "Ton introduction ne peut pas faire moins de 10 caractères."
     * )
     */
    private $introduction;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(
     *  min = 100,
     *  minMessage = "Ta description détaillée ne peut pas faire moins de 100 caractères."
     * )
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ad", mappedBy="author", orphanRemoval=true)
     */
    private $ads;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Trip", mappedBy="traveller", orphanRemoval=true)
     */
    private $trips;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Role", mappedBy="users")
     */
    private $userRoles;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AdBooking", mappedBy="adBooker")
     */
    private $adBookings;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TripBooking", mappedBy="tripBooker", orphanRemoval=true)
     */
    private $tripBookings;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AdComment", mappedBy="author", orphanRemoval=true)
     */
    private $adComments;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TripComment", mappedBy="author", orphanRemoval=true)
     */
    private $tripComments;

    public function getRoles()
    {
    $roles = $this->userRoles->map(function($role){
        return $role->getTitle();
    })->toArray();

    $roles[] = 'ROLE_TRAVELLER';
    $roles[] = 'ROLE_RENTER';
  
    return $roles;
    }

    public function getPassword()
    {
        return $this->hash;
    }

    public function getSalt()
    {


    }

    public function getUsername()
    {
        return $this->email;
    }

    public function eraseCredentials()
    {
        
    }

    public function __construct()
    {
        $this->ads = new ArrayCollection();
        $this->trips = new ArrayCollection();
        $this->userRoles = new ArrayCollection();
        $this->adBookings = new ArrayCollection();
        $this->tripBookings = new ArrayCollection();
        $this->adComments = new ArrayCollection();
        $this->tripComments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getHash(): ?string
    {
        return $this->hash;
    }

    public function setHash(string $hash): self
    {
        $this->hash = $hash;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    /**
     * @return Collection|Ad[]
     */
    public function getAds(): Collection
    {
        return $this->ads;
    }

    public function addAd(Ad $ad): self
    {
        if (!$this->ads->contains($ad)) {
            $this->ads[] = $ad;
            $ad->setAuthor($this);
        }

        return $this;
    }

    public function removeAd(Ad $ad): self
    {
        if ($this->ads->contains($ad)) {
            $this->ads->removeElement($ad);
            // set the owning side to null (unless already changed)
            if ($ad->getAuthor() === $this) {
                $ad->setAuthor(null);
            }
        }

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
            $this->slug = $slugify->slugify($this->firstName.' '.$this->lastName);
        }
    }

    /**
     * @return Collection|Trip[]
     */
    public function getTrips(): Collection
    {
        return $this->trips;
    }

    public function addTrip(Trip $trip): self
    {
        if (!$this->trips->contains($trip)) {
            $this->trips[] = $trip;
            $trip->setTraveller($this);
        }

        return $this;
    }

    public function removeTrip(Trip $trip): self
    {
        if ($this->trips->contains($trip)) {
            $this->trips->removeElement($trip);
            // set the owning side to null (unless already changed)
            if ($trip->getTraveller() === $this) {
                $trip->setTraveller(null);
            }
        }

        return $this;
    }

    public function getFullName()
    {
        return $this->firstName.' '.$this->lastName;
    }

    /**
     * @return Collection|Role[]
     */
    public function getUserRoles(): Collection
    {
        return $this->userRoles;
    }

    public function addUserRole(Role $userRole): self
    {
        if (!$this->userRoles->contains($userRole)) {
            $this->userRoles[] = $userRole;
            $userRole->addUser($this);
        }

        return $this;
    }

    public function removeUserRole(Role $userRole): self
    {
        if ($this->userRoles->contains($userRole)) {
            $this->userRoles->removeElement($userRole);
            $userRole->removeUser($this);
        }

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
            $adBooking->setAdBooker($this);
        }

        return $this;
    }

    public function removeAdBooking(AdBooking $adBooking): self
    {
        if ($this->adBookings->contains($adBooking)) {
            $this->adBookings->removeElement($adBooking);
            // set the owning side to null (unless already changed)
            if ($adBooking->getAdBooker() === $this) {
                $adBooking->setAdBooker(null);
            }
        }

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
            $tripBooking->setTripBooker($this);
        }

        return $this;
    }

    public function removeTripBooking(TripBooking $tripBooking): self
    {
        if ($this->tripBookings->contains($tripBooking)) {
            $this->tripBookings->removeElement($tripBooking);
            // set the owning side to null (unless already changed)
            if ($tripBooking->getTripBooker() === $this) {
                $tripBooking->setTripBooker(null);
            }
        }

        return $this;
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
            $adComment->setAuthor($this);
        }

        return $this;
    }

    public function removeAdComment(AdComment $adComment): self
    {
        if ($this->adComments->contains($adComment)) {
            $this->adComments->removeElement($adComment);
            // set the owning side to null (unless already changed)
            if ($adComment->getAuthor() === $this) {
                $adComment->setAuthor(null);
            }
        }

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
            $tripComment->setAuthor($this);
        }

        return $this;
    }

    public function removeTripComment(TripComment $tripComment): self
    {
        if ($this->tripComments->contains($tripComment)) {
            $this->tripComments->removeElement($tripComment);
            // set the owning side to null (unless already changed)
            if ($tripComment->getAuthor() === $this) {
                $tripComment->setAuthor(null);
            }
        }

        return $this;
    }
}
