<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Schedule
 *
 * @ORM\Table(name="schedule", indexes={@ORM\Index(name="idx_schedule_name", columns={"name"}), @ORM\Index(name="schedule_ibfk_1", columns={"last_update_user_id"})})
 * @ORM\Entity
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
     * @ORM\Column(name="create_at", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $createAt = 'CURRENT_TIMESTAMP';

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


}
