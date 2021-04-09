<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Planning
 *
 * @ORM\Table(name="planning", indexes={@ORM\Index(name="last_update_user_id", columns={"last_update_user_id"}), @ORM\Index(name="schedule_id", columns={"schedule_id"}), @ORM\Index(name="idx_scheduleplanning_dateschedule", columns={"employee_id", "date_schedule"}), @ORM\Index(name="vehicle_id", columns={"vehicle_id"}), @ORM\Index(name="IDX_D499BFF68C03F15C", columns={"employee_id"})})
 * @ORM\Entity
 */
class Planning
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
     * @var \DateTime
     *
     * @ORM\Column(name="date_schedule", type="date", nullable=false)
     */
    private $dateSchedule;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="amplitude_start", type="time", nullable=true)
     */
    private $amplitudeStart;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="amplitude_end", type="time", nullable=true)
     */
    private $amplitudeEnd;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="amplitude", type="time", nullable=true)
     */
    private $amplitude;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="extra_hour", type="time", nullable=true)
     */
    private $extraHour;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="time_work", type="time", nullable=true)
     */
    private $timework;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_update_at", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $lastUpdateAt;

    /**
     * @var string|null
     *
     * @ORM\Column(name="first_break_place", type="string", length=255, nullable=true)
     */
    private $firstBreakPlace;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="first_break_end", type="time", nullable=true)
     */
    private $firstBreakEnd;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="first_break_start", type="time", nullable=true)
     */
    private $firstBreakStart;

    /**
     * @var string|null
     *
     * @ORM\Column(name="second_break_place", type="string", length=255, nullable=true)
     */
    private $secondBreakPlace;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="second_break_start", type="time", nullable=true)
     */
    private $secondBreakStart;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="second_break_end", type="time", nullable=true)
     */
    private $secondBreakEnd;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="create_at", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $createAt = 'CURRENT_TIMESTAMP';

    /**
     * @var \Employee
     *
     * @ORM\ManyToOne(targetEntity="Employee")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="employee_id", referencedColumnName="id")
     * })
     */
    private $employee;

    /**
     * @var \Schedule
     *
     * @ORM\ManyToOne(targetEntity="Schedule")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="schedule_id", referencedColumnName="id")
     * })
     */
    private $schedule;

    /**
     * @var \Vehicle
     *
     * @ORM\ManyToOne(targetEntity="Vehicle")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="vehicle_id", referencedColumnName="id")
     * })
     */
    private $vehicle;

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

    public function getDateSchedule(): ?\DateTimeInterface
    {
        return $this->dateSchedule;
    }

    public function setDateSchedule(\DateTimeInterface $dateSchedule): self
    {
        $this->dateSchedule = $dateSchedule;

        return $this;
    }

    public function getAmplitudeStart(): ?\DateTimeInterface
    {
        return $this->amplitudeStart;
    }

    public function setAmplitudeStart(?\DateTimeInterface $amplitudeStart): self
    {
        $this->amplitudeStart = $amplitudeStart;

        return $this;
    }

    public function getAmplitudeEnd(): ?\DateTimeInterface
    {
        return $this->amplitudeEnd;
    }

    public function setAmplitudeEnd(?\DateTimeInterface $amplitudeEnd): self
    {
        $this->amplitudeEnd = $amplitudeEnd;

        return $this;
    }

    public function getAmplitude(): ?\DateTimeInterface
    {
        return $this->amplitude;
    }

    public function setAmplitude(?\DateTimeInterface $amplitude): self
    {
        $this->amplitude = $amplitude;

        return $this;
    }

    public function getExtraHour(): ?\DateTimeInterface
    {
        return $this->extraHour;
    }

    public function setExtraHour(?\DateTimeInterface $extraHour): self
    {
        $this->extraHour = $extraHour;

        return $this;
    }

    public function getTimeWork(): ?\DateTimeInterface
    {
        return $this->timework;
    }

    public function setTimeWork(?\DateTimeInterface $timework): self
    {
        $this->timework = $timework;

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

    public function getFirstBreakPlace(): ?string
    {
        return $this->firstBreakPlace;
    }

    public function setFirstBreakPlace(?string $firstBreakPlace): self
    {
        $this->firstBreakPlace = $firstBreakPlace;

        return $this;
    }

    public function getFirstBreakEnd(): ?\DateTimeInterface
    {
        return $this->firstBreakEnd;
    }

    public function setFirstBreakEnd(?\DateTimeInterface $firstBreakEnd): self
    {
        $this->firstBreakEnd = $firstBreakEnd;

        return $this;
    }

    public function getFirstBreakStart(): ?\DateTimeInterface
    {
        return $this->firstBreakStart;
    }

    public function setFirstBreakStart(?\DateTimeInterface $firstBreakStart): self
    {
        $this->firstBreakStart = $firstBreakStart;

        return $this;
    }

    public function getSecondBreakPlace(): ?string
    {
        return $this->secondBreakPlace;
    }

    public function setSecondBreakPlace(?string $secondBreakPlace): self
    {
        $this->secondBreakPlace = $secondBreakPlace;

        return $this;
    }

    public function getSecondBreakStart(): ?\DateTimeInterface
    {
        return $this->secondBreakStart;
    }

    public function setSecondBreakStart(?\DateTimeInterface $secondBreakStart): self
    {
        $this->secondBreakStart = $secondBreakStart;

        return $this;
    }

    public function getSecondBreakEnd(): ?\DateTimeInterface
    {
        return $this->secondBreakEnd;
    }

    public function setSecondBreakEnd(?\DateTimeInterface $secondBreakEnd): self
    {
        $this->secondBreakEnd = $secondBreakEnd;

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

    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    public function setEmployee(?Employee $employee): self
    {
        $this->employee = $employee;

        return $this;
    }

    public function getSchedule(): ?Schedule
    {
        return $this->schedule;
    }

    public function setSchedule(?Schedule $schedule): self
    {
        $this->schedule = $schedule;

        return $this;
    }

    public function getVehicle(): ?Vehicle
    {
        return $this->vehicle;
    }

    public function setVehicle(?Vehicle $vehicle): self
    {
        $this->vehicle = $vehicle;

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
