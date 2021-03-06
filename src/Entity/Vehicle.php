<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Vehicle
 *
 * @ORM\Table(name="vehicle", uniqueConstraints={@ORM\UniqueConstraint(name="uniqueimat", columns={"immat"})}, indexes={@ORM\Index(name="idx_vehicle_immat", columns={"immat"}), @ORM\Index(name="vehicle_ibfk_1", columns={"last_update_user_id"}), @ORM\Index(name="idx_vehicle_name", columns={"name"})})
 * @ORM\Entity
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
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="immat", type="string", length=255, nullable=true)
     */
    private $immat;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="create_at", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $createAt ;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="last_update_at", type="datetime", nullable=true, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $lastUpdateAt = 'CURRENT_TIMESTAMP';

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="last_update_user_id", referencedColumnName="id")
     * })
     */
    private $lastUpdateUser;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_place", type="integer", nullable=false)
     */
    private $nbPlace;

    public function __construct()
    {
        $this->createAt = new DateTime();
    }

    public function __toString(){
        return $this->immat." - ".$this->name;
    }

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

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeInterface $createAt): self
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function getLastUpdateAt(): ?\DateTimeInterface
    {
        return $this->lastUpdateAt;
    }

    public function setLastUpdateAt(?\DateTimeInterface $lastUpdateAt): self
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

    public function getNbPlace(): ?int
    {
        return $this->nbPlace;
    }

    public function setNbPlace(int $nbPlace): self
    {
        $this->nbPlace = $nbPlace;

        return $this;
    }


}
