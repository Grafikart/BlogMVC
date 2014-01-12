<?php

namespace Blog\Service;

use Doctrine\Common\Persistence\ObjectManager;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class CacheService implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    /** @var ObjectManager */
    private $em;
    /** @var  CategoryService */
    private $categoryService;

    public function __construct(ObjectManager $em, CategoryService $categoryService)
    {
        $this->em              = $em;
        $this->categoryService = $categoryService;
    }

    public function generateCache(PostService $postService)
    {
        $posts = $postService->getLastPost();
        $categories = $this->categoryService->getAllOrdered();

        $renderer = $this->getServiceLocator()->get('ViewRenderer');
        $view     = $renderer->render('layout/sidebar', array('posts' => $posts, 'categories' => $categories));

        file_put_contents($this->getCacheDirectory() . '/sidebar.cache', $view);
    }

    public function getRootDirectory()
    {
        return getcwd() . DIRECTORY_SEPARATOR;
    }

    public function getDataDirectory()
    {
        return $this->getRootDirectory() . 'data';
    }

    public function getCacheDirectory()
    {
        return $this->getDataDirectory() . DIRECTORY_SEPARATOR . 'cache';
    }
}
