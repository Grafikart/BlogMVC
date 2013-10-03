<?php

namespace Blog\Business\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="Blog\Business\Repository\UserRepository")
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
     * @ORM\Column(name="username", type="string", length=255, nullable=false)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    private $password;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Blog\Business\Entity\Comment", mappedBy="user")
     */
    private $posts;

    public function __construct()
    {
        $this->posts = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    function getPosts()
    {
        return $this->posts;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    public function setPassword($password)
    {
        $this->password = $password;

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

    public static function hashPassword(\Blog\Business\Entity\User $user, $password)
    {
        return ($user->getPassword() === sha1($password));
    }
}
