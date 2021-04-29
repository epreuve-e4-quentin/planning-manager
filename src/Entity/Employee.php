<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Person;

/**
 * Employee
 *
 * @ORM\Table(name="employee")
 * @ORM\Entity
 */
class Employee extends Person
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="firstname", type="string", length=255, nullable=true)
     */
    private $firstname;

    /**
     * @var string|null
     *
     * @ORM\Column(name="adress", type="string", length=255, nullable=true)
     */
    private $adress;

    /**
     * @var string|null
     *
     * @ORM\Column(name="zipcode", type="string", length=255, nullable=true)
     */
    private $zipcode;

    /**
     * @var string|null
     *
     * @ORM\Column(name="city", type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @var string|null
     *
     * @ORM\Column(name="phone", type="string", length=25, nullable=true)
     */
    private $phone;

    /**
     * @var string|null
     *
     * @ORM\Column(name="mobile_phone", type="string", length=25, nullable=true)
     */
    private $mobilePhone;

    /**
     * @var bool
     *
     * @ORM\Column(name="internal", type="boolean", nullable=false)
     */
    private $internal = '0';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="enter_date", type="date", nullable=false)
     */
    private $enterDate;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="end_date", type="date", nullable=true)
     */
    private $endDate;

 

}
