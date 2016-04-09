<?php

namespace Blog\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Article
 *
 * @ORM\Table(name="article", indexes={@ORM\Index(name="category", columns={"category"})})
 * @ORM\Entity
 */
class Article
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
     * @ORM\Column(name="title", type="string", length=100, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="article", type="text", length=65535, nullable=false)
     */
    private $article;

    /**
     * @var string
     *
     * @ORM\Column(name="short_arcticle", type="text", length=65535, nullable=true)
     */
    private $shortArcticle;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_public", type="boolean", nullable=false)
     */
    private $isPublic = '0';

    /**
     * @var \Blog\Entity\Category
     *
     * @ORM\ManyToOne(targetEntity="Blog\Entity\Category")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category", referencedColumnName="id")
     * })
     */
    private $category;



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
     * Set title
     *
     * @param string $title
     *
     * @return Article
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set article
     *
     * @param string $article
     *
     * @return Article
     */
    public function setArticle($article)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return string
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Set shortArcticle
     *
     * @param string $shortArcticle
     *
     * @return Article
     */
    public function setShortArcticle($shortArcticle)
    {
        $this->shortArcticle = $shortArcticle;

        return $this;
    }

    /**
     * Get shortArcticle
     *
     * @return string
     */
    public function getShortArcticle()
    {
        return $this->shortArcticle;
    }

    /**
     * Set isPublic
     *
     * @param boolean $isPublic
     *
     * @return Article
     */
    public function setIsPublic($isPublic)
    {
        $this->isPublic = $isPublic;

        return $this;
    }

    /**
     * Get isPublic
     *
     * @return boolean
     */
    public function getIsPublic()
    {
        return $this->isPublic;
    }

    /**
     * Set category
     *
     * @param \Blog\Entity\Category $category
     *
     * @return Article
     */
    public function setCategory(\Blog\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Blog\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }


    public function getArticleForTable()
    {
        $article = strip_tags($this->article);
        $article = mb_substr($article,0, 15,'UTF8') . '...';
        return $article;
    }
    public function getShortArticleforTable()
    {
        $article = strip_tags($this->getShortArcticle());
        $article = mb_substr($article,0, 20,'UTF8') . '...';
        return $article;
    }

    public function getShortArticleForBody()
    {
        $article = $this->getShortArcticle();
        if(empty($article)){
            $article = $this->getArticle();
        }

        return $article;
    }

    public function getFullArticle()
    {
        $article = $this->getShortArcticle() . $this->getArticle();

        return $article;
    }

    public function __toString()
    {
        return "Article class";
    }
}
