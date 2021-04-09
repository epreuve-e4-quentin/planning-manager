<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="schedule_work_time")
 */
class ScheduleTimeWork {
      /**
     * @var int
     *
     * @ORM\Column(name="schedule_id", type="integer", nullable=false)
     * @ORM\Id
     */
    private $id;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="work_time", type="time", nullable=false)
     */

    private $value	;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?\DateTimeInterface
    {
        return $this->value;
    }

    public function setValue()
    {

    }

  

}