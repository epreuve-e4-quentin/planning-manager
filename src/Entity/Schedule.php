<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Schedule
 *
 * @ORM\Table(name="schedule", indexes={@ORM\Index(name="idx_schedule_name", columns={"name"}), @ORM\Index(name="schedule_ibfk_1", columns={"last_update_user_id"})})
 * @ORM\Entity
 * @UniqueEntity("name", message="{{ value }} est déjà utilisé.")
 * 
 */
class Schedule
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
     * @var \DateTime
     *
     * @ORM\Column(name="default_amplitude", type="time", nullable=false)
     */
    private $defaultAmplitude;

    /**
     * @var float
     *
     * @ORM\Column(name="amplitude_coeff", type="float", precision=10, scale=0, nullable=false)
     */
    private $amplitudeCoeff;

    /**
     * @var bool
     *
     * @ORM\Column(name="default_forced", type="boolean", nullable=false)
     */
    private $defaultForced;

    /**
     * @var \DateTime|null
     * 
     * @ORM\Column(name="amplitude_start_extra", type="time", nullable=true)
     * @Assert\GreaterThanOrEqual(propertyPath="default_amplitude", message="L'heure de début d'amplitude supplémentaire ne peut être inférieur à l'amplitude par défaut.")
     * 
     */
    private $amplitudeStartExtra;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="time_work", type="time", nullable=false)
     */
    private $timeWork;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_update_at", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $lastUpdateAt;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="last_update_user_id", referencedColumnName="id")
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

    public function getDefaultAmplitude(): ?\DateTimeInterface
    {
        return $this->defaultAmplitude;
    }

    public function setDefaultAmplitude(\DateTimeInterface $defaultAmplitude): self
    {
        $this->defaultAmplitude = $defaultAmplitude;

        return $this;
    }

    public function getAmplitudeCoeff(): ?float
    {
        return $this->amplitudeCoeff;
    }

    public function setAmplitudeCoeff(float $amplitudeCoeff): self
    {
        $this->amplitudeCoeff = $amplitudeCoeff;

        return $this;
    }

    public function getDefaultForced(): ?bool
    {
        return $this->defaultForced;
    }

    public function setDefaultForced(bool $defaultForced): self
    {
        $this->defaultForced = $defaultForced;

        return $this;
    }

    public function getAmplitudeStartExtra(): ?\DateTimeInterface
    {
        return $this->amplitudeStartExtra;
    }

    public function setAmplitudeStartExtra(?\DateTimeInterface $amplitudeStartExtra): self
    {
        $this->amplitudeStartExtra = $amplitudeStartExtra;

        return $this;
    }

    public function getTimeWork(): ?\DateTimeInterface
    {
        return $this->timeWork;
    }

    public function setTimeWork(\DateTimeInterface $timeWork): self
    {
        $this->timeWork = $timeWork;

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

    public function __tostring()
    {
        return $this->id . ";".$this->name;
    }


}
