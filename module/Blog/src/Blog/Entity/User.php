<?php

namespace Blog\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;

/**
 * User
 *
 * @ORM\Table(name="user", uniqueConstraints={@ORM\UniqueConstraint(name="unique_key", columns={"user_name"})})
 * @ORM\Entity(repositoryClass="Blog\Entity\Repository\UserRepository")
 * @Annotation\Name("user")
 */
class User
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Annotation\Exclude()
     */
    private $id;

    /**
     * @var string
     * @Annotation\Type("Zend\Form\Element\Text")
     * @ORM\Column(name="user_name", type="string", length=100, nullable=false)
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":3, "max":25}})
     * @Annotation\Attributes({"type":"text", "class":"form-control","required":"required"})
     * @Annotation\Options({"label":"Username:"})
     *
     */
    private $userName;

    /**
     * @var string
     *
     * @ORM\Column(name="user_password", type="string", length=100, nullable=false)
     * @Annotation\Type("Zend\Form\Element\Password")
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":3, "max":25}})
     * @Annotation\Attributes({"type":"password", "class":"form-control","required":"required"})
     * @Annotation\Options({"label":"Password:"})
     */
    private $userPassword;


    /**
     * @var string
     *
     * @Annotation\Type("Zend\Form\Element\Password")
     * @Annotation\Validator({"name":"identical", "options":{"token":"userPassword"}})
     * @Annotation\Attributes({"type":"password", "class":"form-control","required":"required"})
     * @Annotation\Options({"label":"ConfirmPassword:"})
     *
     */
    public $confimPasswor;

    /**
     * @var string
     *
     * @ORM\Column(name="user_email", type="string", length=100, nullable=false)
     * @Annotation\Type("Zend\Form\Element\Email")
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":25}})
     * @Annotation\Attributes({"type":"email", "class":"form-control","required":"required"})
     * @Annotation\Options({"label":"Username:"})
     * @Annotation\Validator({"name":"EmailAddress"})
     */
    private $userEmail;

    /**
     * @Annotation\Type("Zend\Form\Element\Submit")
     * @Annotation\Attributes({"value":"Войти", "id":"btn-submit","class":"btn btn-primary"})
     * @Annotation\AllowEmpty({"allowempty":"true"})
     */
    public $submit;

    /**
     * @var string
     *
     * @ORM\Column(name="user_password_salt", type="string", length=100, nullable=false)
     * @Annotation\Attributes({"type":"text", "class":"form-control"})
     * @Annotation\Options({"label":"Salt:"})
     */
    private $userPasswordSalt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="user_register_date", type="datetime", nullable=true)
     * @Annotation\Attributes({"type":"date", "class":"form-control", "min":"2010-01-01T00:00:00Z","max":"2020-01-01T00:00:00Z","step":"1"})
     * @Annotation\Options({"label":"DateRegister"})
     */
    private $userRegisterDate;

    public function __construct()
    {
        $this->userRegisterDate = new \DateTime();
    }

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
