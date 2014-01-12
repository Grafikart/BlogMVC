<?php

namespace Blog\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * Post
 *
 * @ORM\Table(name="posts", indexes={@ORM\Index(name="fk_posts_categories_idx", columns={"category_id"}), @ORM\Index(name="fk_posts_users1_idx", columns={"user_id"})})
 * @ORM\Entity(repositoryClass="Blog\Repository\PostRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Post
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
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255, nullable=false)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", nullable=false)
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    private $created;

    /**
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="Blog\Entity\Category", inversedBy="posts")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * })
     */
    private $category;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Blog\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Blog\Entity\Comment", mappedBy="post", cascade={"remove"})
     * @ORM\OrderBy({"created" = "DESC"})
     */
    private $comments;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

    function getId()
    {
        return $this->id;
    }

    function getName()
    {
        return $this->name;
    }

    function getSlug()
    {
        return $this->slug;
    }

    function getContent()
    {
        return $this->content;
    }

    function getCreated()
    {
        if ($this->created) {
            return clone $this->created;
        }
        return $this->created;
    }

    function getCategory()
    {
        return $this->category;
    }

    function getUser()
    {
        return $this->user;
    }

    function getComments()
    {
        return $this->comments;
    }

    function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    function setCreated(DateTime $created)
    {
        $this->created = clone $created;

        return $this;
    }

    function setCategory(Category $category)
    {
        $this->category = $category;

        return $this;
    }

    function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    function addComments(Comment $comments)
    {
        if (! $this->comments->contains($comments)) {
            $this->comments->add($comments);
        }

        return $this;
    }

    function removeComments(Comment $comments)
    {
        if ($this->comments->contains($comments)) {
            $this->comments->removeElement($comments);
        }

        return $this;
    }

    /**
     * @ORM\PrePersist()
     */
    public function preSave()
    {
        $this->setCreated(new DateTime());
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpdate()
    {
        if ('' == trim($this->getSlug())) {
            $this->setSlug(\Gedmo\Sluggable\Util\Urlizer::urlize($this->getName()));
        }
    }
}
