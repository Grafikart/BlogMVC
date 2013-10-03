<?php

namespace Blog\Business\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table(name="categories")
 * @ORM\Entity(repositoryClass="Blog\Business\Repository\CategoryRepository")
 */
class Category
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
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=50, nullable=false)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="post_count", type="string", length=50, nullable=false)
     */
    private $postCount;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Blog\Business\Entity\Post", mappedBy="category")
     * @ORM\OrderBy({"created"="DESC"})
     */
    private $posts;

    public function __construct()
    {
        $this->posts = new \Doctrine\Common\Collections\ArrayCollection();
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

    function getPostCount()
    {
        // TODO
        return $this->postCount;
    }

    function getPosts()
    {
        return $this->posts;
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

    function addPost(\Blog\Business\Entity\Post $post)
    {
        if (! $this->posts->contains($post)) {
            $this->posts->add($post);
        }

        return $this;
    }

    function removePost(\Blog\Business\Entity\Post $post)
    {
        if ($this->posts->contains($post)) {
            $this->posts->removeElement($post);
        }

        return $this;
    }
}
