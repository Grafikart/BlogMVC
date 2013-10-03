<?php

namespace Blog\Business\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comment
 *
 * @ORM\Table(name="comments", indexes={@ORM\Index(name="fk_comments_posts1_idx", columns={"post_id"})})
 * @ORM\Entity(repositoryClass="Blog\Business\Repository\CommentRepository")
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
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    private $created;

    /**
     * @var \Blog\Business\Entity\Post
     *
     * @ORM\ManyToOne(targetEntity="Blog\Business\Entity\Post")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     * })
     */
    private $post;

    function getId()
    {
        return $this->id;
    }

    function getUsername()
    {
        return $this->username;
    }

    function getMail()
    {
        return $this->mail;
    }

    function getContent()
    {
        return $this->content;
    }

    function getCreated()
    {
        return $this->created;
    }

    function getPost()
    {
        return $this->post;
    }

    function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    function setMail($mail)
    {
        $this->mail = $mail;

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

    function setPost(\Blog\Business\Entity\Post $post)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * @ORM\PrePersist()
     */
    public function preSave()
    {
        $this->setCreated(new \DateTime());
    }
}
