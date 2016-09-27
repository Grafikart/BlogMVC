<?php

namespace Acme\BlogBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Acme\UserBundle\Entity\User;
use Acme\BlogBundle\Util\Urlizer;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Category
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Acme\BlogBundle\Entity\PostRepository")
 * @ORM\HasLifecycleCallbacks
 *
 * @UniqueEntity(fields="slug", message="This slug is already used")
 */
class Post
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @ORM\ManyToOne(
     *      targetEntity="Acme\UserBundle\Entity\User"
     * )
     * @ORM\JoinColumn(
     *      name="user_id",
     *      referencedColumnName="id",
     *      nullable=false
     * )
     */
    private $user;

    /**
     * @ORM\ManyToOne(
     *      targetEntity="Category",
     *      inversedBy="posts",
     *      fetch="EAGER"
     * )
     * @ORM\JoinColumn(
     *      name="category_id",
     *      referencedColumnName="id",
     *      nullable=false
     * )
     */
    private $category;

    /**
     * @ORM\OneToMany(
     *      targetEntity="Comment",
     *      mappedBy="post"
     * )
     * @ORM\OrderBy({"created"="DESC"})
     */
    private $comments;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->created = new DateTime();
        $this->comments = new ArrayCollection();
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     *
     * Update created date
     * Generate slug if is not defined
     */
    public function preSave()
    {
        $this->created = new DateTime();

        $slugifiedSlug = Urlizer::urlize($this->getSlug());
        if ($this->getSlug() === null || empty($slugifiedSlug)) {
            $this->slug = Urlizer::urlize($this->getName());
        }
    }

    /*
     *
     */
    public function __toString()
    {
        return $this->getName();
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
     * Set name
     *
     * @param string $name
     *
     * @return Post
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Post
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Post
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set created
     *
     * @param DateTime $created
     *
     * @return Post
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set category
     *
     * @param Category $category
     *
     * @return Post
     */
    public function setCategory(Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Add comments
     *
     * @param Comment $comments
     *
     * @return Post
     */
    public function addComment(Comment $comments)
    {
        $this->comments[] = $comments;

        return $this;
    }

    /**
     * Remove comments
     *
     * @param Comment $comments
     */
    public function removeComment(Comment $comments)
    {
        $this->comments->removeElement($comments);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set user
     *
     * @param User $user
     *
     * @return Post
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
}
