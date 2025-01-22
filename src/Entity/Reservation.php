<?php
namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
#[ORM\Entity(repositoryClass: ReservationRepository::class)]
#[ORM\Table(name: 'reservation_restau')]


class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $ID = null;

    #[ORM\Column(type: 'string', length: 255)]
private $nomComplet; 


    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(type: Types::STRING)]
    private ?string $telephone = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $heure = null;

    #[ORM\Column(type: "integer")]
    private $guests; // Nouvelle propriété

    #[ORM\Column(type: "date")]
    private $date; 
    


    public function getID(): ?int
    {
        return $this->ID;
    }

    public function setID(int $ID): static
    {
        $this->ID = $ID;
        return $this;
    }


public function getNomComplet(): ?string
{
    return $this->nomComplet;
}

public function setNomComplet(string $nomComplet): self
{
    $this->nomComplet = $nomComplet;
    return $this;
}


    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): static
    {
        $this->telephone = $telephone;
        return $this;
    }

    public function getHeure(): ?\DateTimeInterface
    {
        return $this->heure;
    }

    public function setHeure(\DateTimeInterface $heure): static
    {
        $this->heure = $heure;
        return $this;
    }

    public function getGuests(): ?int
    {
        return $this->guests;
    }

    public function setGuests(int $guests): self
    {
        $this->guests = $guests;
        return $this;
    }

    // Getters et setters pour date
    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;
        return $this;
    }

   
    
}
