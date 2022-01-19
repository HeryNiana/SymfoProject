<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(
 * fields={"email"}, 
 * message= "l\'adresse mail que vous avez tapé est déjà utilisé "
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="8",minMessage="votre mot de passe est trés courte")
     * @Assert\EqualTo(propertyPath="confirm_password", message="le mot de passe que vous avez tapé ne sont pas identique")
     */
    private $password;
    /**
     * @Assert\Length(min="8",minMessage="votre mot de passe est trés courte")
     * @Assert\EqualTo(propertyPath="password", message="le mot de passe que vous avez tapé ne sont pas identique")
     */
    public $confirm_password;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

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

    public function eraseCredentials(){}

    public function getSalt(){}
    
    public function getRoles(){
        return ['ROLE_USER'];
    }
    public function serialize()
    {
    return serialize([
        $this->id,
        $this->login,
        $this->password
     ]);
    }
    public function unserialize($string)
    {
    list (
        $this->id,
        $this->login,
        $this->password
    ) = unserialize($string, ['allowed_classes' => false]);
  }
}
