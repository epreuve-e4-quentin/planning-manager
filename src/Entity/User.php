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

    public function getRolesJson(): ?string
    {
        return $this->rolesJson;
    }

    public function setRolesJson(string $rolesJson): self
    {
        $this->rolesJson = $rolesJson;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

  


}