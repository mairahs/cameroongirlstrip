<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class AdContact
{
    /**
     * @var string|null
     * @Assert\Length( min = 2, max = 100)
     * @Assert\NotBlank()
     */
    private $firstName;

    /**
     * @var string|null
     * @Assert\Length( min = 2, max = 100)
     * @Assert\NotBlank()
     */
    private $lastName;

    /**
     * @var string|null
     * @Assert\Regex(
     * pattern="/[0-9]{10}/"
     * )
     * @Assert\NotBlank()
     */
    private $phone;

    /**
     * @var string|null
     * @Assert\Email()
     * @Assert\NotBlank()
     */
    private $email;

    /**
     * @var string|null
     * @Assert\Length( min = 20)
     * @Assert\NotBlank()
     */
    private $message;

    /**
     * @var Ad|null
     */
    private $ad;

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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

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

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getAd(): ?Ad
    {
        return $this->ad;
    }

    public function setAd(Ad $ad): self
    {
        $this->ad = $ad;

        return $this;
    }
}