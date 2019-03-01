<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AdBookingRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class AdBooking
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="adBookings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $adBooker;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ad", inversedBy="adBookings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ad;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\Date(message="Attention, ta date d'entrée dans le logement n'est pas au bon format")
     * @Assert\GreaterThan("today", message="La date d'entrée doit être ultérieure à la date du jour")
     */
    private $startDate;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\Date(message="Attention,ta date de départ du logement n'est pas au bon format")
     * @Assert\GreaterThan(propertyPath="startDate", message="La date de départ doit etre plus éloignée que la date d'entrée")
     */
    private $endDate;

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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdBooker(): ?User
    {
        return $this->adBooker;
    }

    public function setAdBooker(?User $adBooker): self
    {
        $this->adBooker = $adBooker;

        return $this;
    }

    public function getAd(): ?Ad
    {
        return $this->ad;
    }

    public function setAd(?Ad $ad): self
    {
        $this->ad = $ad;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

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
     * Used to automatically generate the ad creation date on today's date
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        if(empty($this->createdAt))
        {
            $this->createdAt = new \DateTime();
        }

        if(empty($this->amount))
        {
            $this->amount = $this->ad->getPrice()*$this->getDuration();
        }
    }
    
    /**
     * Avoid get number of days between two dates
     */
    public function getDuration()
    {
        $diff = $this->endDate->diff($this->startDate);
        return $diff->days;
    }

    /**
     * isBookableDates
     *
     * @return void
     */
    public function isBookableDates()
    {
        $notAvailableDays = $this->ad->getNotAvailableDays();
        $bookingDays = $this->getDays();

        $formatDays = function($day){
            return $day->format('Y-m-d');
        };

        //Tableau de chaines de caractères de mes journées dispo car date en format string est plus facile à comparer que date en format DateTime
        $days             = array_map($formatDays, $bookingDays);
        $notAvailableDays = array_map($formatDays, $notAvailableDays);

        foreach($days as $day)
        {
            if(array_search($day, $notAvailableDays) !== false)
            {
                return false;
            }
        }

        return true;

    }

    /**
     * avoid an array of days which matching with the booking
     *
     * @return \DateTime []
     */
    public function getDays()
    {
        $result = range($this->startDate->getTimestamp(), $this->endDate->getTimestamp(), 24*60*60);
        $days = array_map(function($dayTimestamp){
            return new \DateTime(date('Y-m-d', $dayTimestamp));
        }, $result);
        return $days;
    }

}
