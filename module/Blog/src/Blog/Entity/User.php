<?php

namespace Blog\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="user", uniqueConstraints={@ORM\UniqueConstraint(name="unique_key", columns={"user_name"})})
 * @ORM\Entity
 */
class User
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="user_name", type="string", length=100, nullable=false)
     */
    private $userName;

    /**
     * @var string
     *
     * @ORM\Column(name="user_password", type="string", length=100, nullable=false)
     */
    private $userPassword;

    /**
     * @var string
     *
     * @ORM\Column(name="user_email", type="string", length=100, nullable=false)
     */
    private $userEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="user_password_salt", type="string", length=100, nullable=false)
     */
    private $userPasswordSalt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="user_register_date", type="datetime", nullable=true)
     */
    private $userRegisterDate;



    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set userName
     *
     * @param string $userName
     *
     * @return User
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;

        return $this;
    }

    /**
     * Get userName
     *
     * @return string
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * Set userPassword
     *
     * @param string $userPassword
     *
     * @return User
     */
    public function setUserPassword($userPassword)
    {
        $this->userPassword = $userPassword;

        return $this;
    }

    /**
     * Get userPassword
     *
     * @return string
     */
    public function getUserPassword()
    {
        return $this->userPassword;
    }

    /**
     * Set userEmail
     *
     * @param string $userEmail
     *
     * @return User
     */
    public function setUserEmail($userEmail)
    {
        $this->userEmail = $userEmail;

        return $this;
    }

    /**
     * Get userEmail
     *
     * @return string
     */
    public function getUserEmail()
    {
        return $this->userEmail;
    }

    /**
     * Set userPasswordSalt
     *
     * @param string $userPasswordSalt
     *
     * @return User
     */
    public function setUserPasswordSalt($userPasswordSalt)
    {
        $this->userPasswordSalt = $userPasswordSalt;

        return $this;
    }

    /**
     * Get userPasswordSalt
     *
     * @return string
     */
    public function getUserPasswordSalt()
    {
        return $this->userPasswordSalt;
    }

    /**
     * Set userRegisterDate
     *
     * @param \DateTime $userRegisterDate
     *
     * @return User
     */
    public function setUserRegisterDate($userRegisterDate)
    {
        $this->userRegisterDate = $userRegisterDate;

        return $this;
    }

    /**
     * Get userRegisterDate
     *
     * @return \DateTime
     */
    public function getUserRegisterDate()
    {
        return $this->userRegisterDate;
    }
}
