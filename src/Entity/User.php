<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\Person;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity
 */
class User extends Person implements UserInterface
{
    /**
     * @var string
     *
     * @ORM\Column(name="roles_json", type="text", length=65535, nullable=false)
     */
    private $rolesJson;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=250, nullable=false)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=250, nullable=false)
     */
    private $username;


    
    //-------------User Interface------------------
    public function eraseCredentials()
    {
    }
    public function getSalt()
    {
    }
    public function getRoles()
    {
        return json_decode($this->rolesJson);
    }
    //---------------------------------------------


}
