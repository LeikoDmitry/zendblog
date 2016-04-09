<?php

namespace Blog\Entity;
//@Annotation\Validator({"name":"EmailAdress"})
use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;

/**
 * Comment
 *
 * @ORM\Table(name="comment", indexes={@ORM\Index(name="arcticle", columns={"arcticle"})})
 * @ORM\Entity
 */
class Comment
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Annotation\Type("Zend\Form\Element\Hidden")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="user_email", type="string", length=50, nullable=false)
     * @Annotation\Type("Zend\Form\Element\Email")
     * @Annotation\Options({"label":"Email"})
     * @Annotation\Required({"required":"true"})
     * @Annotation\Attributes({"id":"user_email", "class":"form-control","required":"required"})
     *
     */
    private $userEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text", length=65535, nullable=false)
     * @Annotation\Type("Zend\Form\Element\Textarea")
     * @Annotation\Required({"required":"true"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Options({"label":"Комментарии"})
     * @Annotation\Attributes({"id":"user_comment", "class":"form-control"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":11, "max":30}})
     */
    private $comment;

    /**
     * @var \Blog\Entity\Article
     *
     * @ORM\ManyToOne(targetEntity="Blog\Entity\Article")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="arcticle", referencedColumnName="id")
     * })
     * @Annotation\Options({"label":"Комментарий"})
     */
    private $arcticle;

    /**
     * @Annotation\Type("Zend\Form\Element\Submit")
     * @Annotation\Attributes({"value":"Сохранить", "id":"btn-submit","class":"btn btn-primary"})
     * @Annotation\AllowEmpty({"allowempty":"true"})
     */
    public $submit;



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
     * Set userEmail
     *
     * @param string $userEmail
     *
     * @return Comment
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
     * Set comment
     *
     * @param string $comment
     *
     * @return Comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set arcticle
     *
     * @param \Blog\Entity\Article $arcticle
     *
     * @return Comment
     */
    public function setArcticle(\Blog\Entity\Article $arcticle = null)
    {
        $this->arcticle = $arcticle;

        return $this;
    }

    /**
     * Get arcticle
     *
     * @return \Blog\Entity\Article
     */
    public function getArcticle()
    {
        return $this->arcticle;
    }
}
