<?php

namespace Blog\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * Comment
 *
 * @ORM\Table(name="comments", indexes={@ORM\Index(name="fk_comments_posts1_idx", columns={"post_id"})})
 * @ORM\Entity(repositoryClass="Blog\Repository\CommentRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Comment
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
     * @ORM\Column(name="mail", type="string", length=255, nullable=false)
     */
    private $mail;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", nullable=false)
     */
    private $content;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    private $created;

    /**
     * @var Post
     *
     * @ORM\ManyToOne(targetEntity="Blog\Entity\Post")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     * })
     */
    private $post;

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getMail()
    {
        return $this->mail;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getCreated()
    {
        return $this->created;
    }

    public function getPost()
    {
        return $this->post;
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

    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    public function setCreated(DateTime $created)
    {
        $this->created = clone $created;

        return $this;
    }

    public function setPost(Post $post)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * @ORM\PrePersist()
     */
    public function preSave()
    {
        $this->setCreated(new DateTime());
    }
}
