<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 * @UniqueEntity(fields="email", message="Email already taken")
 * @UniqueEntity(fields="username", message="Username already taken")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank()
     */
    private $username;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=4096)
     */
    private $plainPassword;

    /**
     * The below length depends on the "algorithm" you use for encoding
     * the password, but this works well with bcrypt.
     *
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @ORM\Column(type="array")
     */
    private $roles;

    public function __construct()
    {
        $this->roles = array('ROLE_ADMIN');
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param $password
     */
    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return null|string
     */
    public function getSalt()
    {
        // The bcrypt and argon2i algorithms don't require a separate salt.
        // You *may* need a real salt if you choose a different encoder.
        return null;
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     *
     */
    public function eraseCredentials()
    {
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
          $this->id,
          $this->username,
          $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
          $this->id,
          $this->username,
          $this->password,
          // see section on salt below
          // $this->salt
          ) = unserialize($serialized, array('allowed_classes' => false));
    }
}
//
//namespace App\Entity;
//
//use Doctrine\ORM\Mapping as ORM;
//use Symfony\Component\Validator\Constraints as Assert;
//use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
//use Symfony\Component\Security\Core\User\UserInterface;
//
///**
// * @ORM\Table(name="app_users")
// * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
// * @UniqueEntity(fields="email", message="Email already taken")
// * @UniqueEntity(fields="username", message="Username already taken")
// */
//class User implements UserInterface, \Serializable
//{
//
//    /**
//     * @ORM\Id
//     * @ORM\Column(type="integer")
//     * @ORM\GeneratedValue(strategy="AUTO")
//     */
//    private $id;
//
//    /**
//     * @ORM\Column(type="string", length=255, unique=true)
//     * @Assert\NotBlank()
//     * @Assert\Email()
//     */
//    private $email;
//
//    /**
//     * @ORM\Column(type="string", length=255, unique=true)
//     * @Assert\NotBlank()
//     */
//    private $username;
//
//    /**
//     * @Assert\NotBlank()
//     * @Assert\Length(max=4096)
//     */
//    private $plainPassword;
//
//    /**
//     * The below length depends on the "algorithm" you use for encoding
//     * the password, but this works well with bcrypt.
//     *
//     * @ORM\Column(type="string", length=64)
//     */
//    private $password;
//
//    /**
//     * @ORM\Column(type="array")
//     */
//    private $roles;
//
//    public function __construct()
//    {
//        $this->roles = ['ROLE_USER'];
//    }
//
//    /**
//     * @return null|string
//     */
//    public function getEmail(): ?string
//    {
//        return $this->email;
//    }
//
//    /**
//     * @param $email
//     */
//    public function setEmail($email): void
//    {
//        $this->email = $email;
//    }
//
//    /**
//     * @return mixed
//     */
//    public function getUsername(): ?string
//    {
//        return $this->username;
//    }
//
//    /**
//     * @param $username
//     */
//    public function setUsername($username): void
//    {
//        $this->username = $username;
//    }
//
//    /**
//     * @return null|string
//     */
//    public function getPlainPassword(): ?string
//    {
//        return $this->plainPassword;
//    }
//
//    /**
//     * @param $password
//     */
//    public function setPlainPassword($password): void
//    {
//        $this->plainPassword = $password;
//    }
//
//    /**
//     * @return null|string
//     */
//    public function getPassword(): ?string
//    {
//        return $this->password;
//    }
//
//    /**
//     * @param $password
//     */
//    public function setPassword($password): void
//    {
//        $this->password = $password;
//    }
//
//    /**
//     * @return null|string
//     */
//    public function getSalt()
//    {
//        // The bcrypt and argon2i algorithms don't require a separate salt.
//        // You *may* need a real salt if you choose a different encoder.
//        return null;
//    }
//
//
//    public function getRoles(): ?array
//    {
//        return $this->roles;
//    }
//
//    public function eraseCredentials(): void
//    {
//    }
//
//    /** @see \Serializable::serialize() */
//    public function serialize()
//    {
//        return serialize([
//          $this->id,
//          $this->username,
//          $this->password,
//            // see section on salt below
//            // $this->salt,
//        ]);
//    }
//
//    /** @see \Serializable::unserialize()
//     * @param $serialized
//     */
//    public function unserialize($serialized): void
//    {
//        [
//          $this->id,
//          $this->username,
//          $this->password,
//            // see section on salt below
//            // $this->salt
//        ]
//          = unserialize($serialized, ['allowed_classes' => false]);
//    }
//}