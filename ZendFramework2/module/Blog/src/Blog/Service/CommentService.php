<?php

namespace Blog\Service;

use Blog\Entity\Comment;
use Blog\Entity\Post;
use Blog\Repository\CommentRepository;
use Doctrine\Common\Persistence\ObjectManager;

class CommentService
{

    /** @var ObjectManager */
    private $em;

    public function __construct(ObjectManager $em)
    {
        $this->em = $em;
    }

    public function addComment(Comment $comment, Post $post)
    {
        $comment->setPost($post);

        $this->em->persist($comment);
        $this->em->flush($comment);
    }

    /**
     * @return CommentRepository
     */
    public function getRepository()
    {
        return $this->em->getRepository('Blog\Entity\Comment');
    }
}
