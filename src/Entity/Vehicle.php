<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert ;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Vehicle
 *
 * @ORM\Table(name="vehicle", uniqueConstraints={@ORM\UniqueConstraint(name="uniqueimat", columns={"immat"})}, indexes={@ORM\Index(name="idx_vehicle_immat", columns={"immat"}), @ORM\Index(name="last_update_user_id", columns={"last_update_user_id"}), @ORM\Index(name="idx_vehicle_name", columns={"name"})})
 * @ORM\Entity
 * @UniqueEntity("immat", message="{{ value }} est déjà utilisé.")
 */

class Vehicle
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     * @Assert\Length(min=5,max=255 , minMessage="Votre Nom de véhicule est trop court, il doit contenir au minimum 5 caractères" )
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="immat", type="string", length=255, nullable=true)
     * @Assert\Length(min=5,max=255, minMessage="Votre Immatriculation de véhicule est trop courte votre plaque doit contenir au minimum 5 caractères" )*
     */
    private $immat;
    /**
     * @var \DateTime
     * @ORM\Column(name="last_update_at", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $lastUpdateAt = 'CURRENT_TIMESTAMP';

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="last_update_user_id", referencedColumnName="id")
     * })
     */



     
    private $lastUpdateUser;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getImmat(): ?string
    {
        return $this->immat;
    }

    public function setImmat(?string $immat): self
    {
        $this->immat = $immat;

        return $this;
    }

    public function getLastUpdateAt(): ?\DateTimeInterface
    {
        return $this->lastUpdateAt;
    }

    public function setLastUpdateAt(\DateTimeInterface $lastUpdateAt): self
    {
        $this->lastUpdateAt = $lastUpdateAt;

        return $this;
    }

    public function getLastUpdateUser(): ?User
    {
        return $this->lastUpdateUser;
    }

    public function setLastUpdateUser(?User $lastUpdateUser): self
    {
        $this->lastUpdateUser = $lastUpdateUser;

        return $this;
    }

}
