<?php

namespace Acme\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Acme\BlogBundle\Util\Urlizer;

/**
 * Category
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Acme\BlogBundle\Entity\CategoryRepository")
 * @ORM\HasLifecycleCallbacks
 *
 * @UniqueEntity(fields="slug", message="This slug is already used")
 */
class Category
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
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;

    /**
     * @var integer
     *
     * @ORM\Column(name="post_count", type="integer")
     */
    private $postCount;

    /**
     * @ORM\OneToMany(
     *      targetEntity="Post",
     *      mappedBy="category"
     * )
     */
    private $posts;



    public function __toString(){
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
     * @return Category
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
     * @return Category
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
     * Set postCount
     *
     * @param integer $postCount
     *
     * @return Category
     */
    public function setPostCount($postCount)
    {
        $this->postCount = $postCount;
    
        return $this;
    }

    /**
     * Get postCount
     *
     * @return integer 
     */
    public function getPostCount()
    {
        return $this->postCount;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->posts = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add posts
     *
     * @param \Acme\BlogBundle\Entity\Post $posts
     *
     * @return Category
     */
    public function addPost(\Acme\BlogBundle\Entity\Post $posts)
    {
        $this->posts[] = $posts;
    
        return $this;
    }

    /**
     * Remove posts
     *
     * @param \Acme\BlogBundle\Entity\Post $posts
     */
    public function removePost(\Acme\BlogBundle\Entity\Post $posts)
    {
        $this->posts->removeElement($posts);
    }

    /**
     * Get posts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPosts()
    {
        return $this->posts;
    }
}
