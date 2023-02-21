<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity()]
#[ORM\Table(name: "restaurant_bookings")]
class Book
{
    #[ORM\Id()]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    #[ORM\Column(type: "integer")]
    private int $id;
    
    #[ORM\Column(type: "integer")]
    private int $preferedGroupNumber;

    #[ORM\Column(nullable: true)]
    private ?string $allergies;

    #[ORM\ManyToOne(targetEntity: "App\Entity\Customers", inversedBy: "bookings")]
    #[ORM\JoinColumn(name: "customers_email", referencedColumnName: "email", onDelete: "CASCADE")]
    private $user;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getPreferedGroupNumber()
    {
        return $this->preferedGroupNumber;
    }

    public function setPreferedGroupNumber($preferedGroupNumber)
    {
        $this->preferedGroupNumber = $preferedGroupNumber;

        return $this;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    public function getAllergies()
    {
        return $this->allergies;
    }

    public function setAllergies($allergies)
    {
        $this->allergies = $allergies;

        return $this;
    }
}