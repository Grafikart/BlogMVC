<?php

namespace Blog\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Post
 *
 * @ORM\Table(name="posts", indexes={@ORM\Index(name="fk_posts_categories_idx", columns={"category_id"}), @ORM\Index(name="fk_posts_users1_idx", columns={"user_id"})})
 * @ORM\Entity(repositoryClass="Blog\Repository\PostRepository")
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
     * @var \Blog\Entity\Category
     *
     * @ORM\ManyToOne(targetEntity="Blog\Entity\Category")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * })
     */
    private $category;

    /**
     * @var \Blog\Entity\User
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
     * @ORM\OneToMany(targetEntity="Blog\Entity\Comment", mappedBy="post")
     */
    private $comments;

    public function __construct()
    {
        $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
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

    function setCreated(\DateTime $created)
    {
        $this->created = $created;

        return $this;
    }

    function setCategory(\Blog\Entity\Category $category)
    {
        $this->category = $category;

        return $this;
    }

    function setUser(\Blog\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    function addComments(\Blog\Entity\Comments $comments)
    {
        if (! $this->commentss->contains($comments)) {
            $this->commentss->add($comments);
        }

        return $this;
    }

    function removeComments(\Blog\Entity\Comments $comments)
    {
        if ($this->commentss->contains($comments)) {
            $this->commentss->removeElement($comments);
        }

        return $this;
    }
}
