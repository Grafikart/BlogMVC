<?php

namespace Blog\Service;

use Blog\Entity\Post;
use Blog\Repository\PostRepository;
use Doctrine\Common\Persistence\ObjectManager;

class PostService
{
    /** @var ObjectManager */
    private $em;

    /** @var CacheService */
    private $cacheService;

    public function __construct(ObjectManager $em, CacheService $cacheService)
    {
        $this->em           = $em;
        $this->cacheService = $cacheService;
    }

    /**
     * @param array $criteria
     * @return \Zend\Paginator\Paginator
     */
    public function getActivePost(array $criteria = array())
    {
        return $this->getRepository()->findActivePost($criteria);
    }

    public function getPostBySlug($slug)
    {
        return $this->getRepository()->findOneBy(array(
            'slug' => $slug,
        ));
    }

    public function getPostById($id)
    {
        return $this->getRepository()->findOneBy(array('id' => $id));
    }

    public function getLastPost()
    {
        return $this->getRepository()->findLastPost();
    }

    public function addPost(Post $post)
    {
        if (!$post->getSlug()) {
            $post->setSlug(str_replace(' ', '-', strtolower($post->getName())));
        }

        $this->em->persist($post);
        $this->em->flush($post);

        $this->cacheService->generateCache($this);
    }

    public function updatePost(Post $post)
    {
        if (!$post->getSlug()) {
            $post->setSlug(str_replace(' ', '-', strtolower($post->getName())));
        }

        $this->em->flush($post);

        $this->cacheService->generateCache($this);
    }

    public function deletePost(Post $post)
    {
        $this->em->remove($post);
        $this->em->flush($post);

        $this->cacheService->generateCache($this);
    }

    /**
     * @return PostRepository
     */
    public function getRepository()
    {
        return $this->em->getRepository('Blog\Entity\Post');
    }
}
