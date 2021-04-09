<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert ;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * User
 *
 * @ORM\Table(name="user", indexes={@ORM\Index(name="idx_user_username", columns={"username"}), @ORM\Index(name="last_update_user_id", columns={"last_update_user_id"})})
 * @ORM\Entity
 * 
 * @UniqueEntity(fields = {"email"}, message="L'email est déjà utilisé" )
 * @UniqueEntity(fields = {"username"}, message="username est déjà utilisé" )
 * 
 */
class User implements UserInterface
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
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     * @Assert\Email( message = "The email '{{ value }}' is not a valid email.")
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255, nullable=false)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="roles_json", type="text", length=255, nullable=false)
     */
    private $rolesJson;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_update_at", type="datetime", nullable=true)
     */
    private $lastUpdateAt ;
    
    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     * @Assert\Length(min="8", minMessage="Votre mot de passe doit faire minimum 8 caractères")
     */
    private $password;

    /**
     * @var string
     *
     * @Assert\EqualTo(propertyPath="password", message="Votre mot passse de confirmation n'est pas le même que dans le champ password")
     */
    public $confirm_password;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="last_update_user_id", referencedColumnName="id")
     * })
     */
    private $lastUpdateUser;

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
    //-------------User Interface------------------
    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRolesJson(): ?string
    {
        return $this->rolesJson;
    }

    public function setRolesJson(string $rolesJson): self
    {
        $this->rolesJson = $rolesJson;

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

    public function getLastUpdateUser(): ?self
    {
        return $this->lastUpdateUser;
    }

    public function setLastUpdateUser(?self $lastUpdateUser): self
    {
        $this->lastUpdateUser = $lastUpdateUser;

        return $this;
    }


}
