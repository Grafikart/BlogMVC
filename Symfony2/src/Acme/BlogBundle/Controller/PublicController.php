<?php

namespace Acme\BlogBundle\Controller;

use Acme\BlogBundle\Controller\AbstractPaginatorController;

/**
 * Public controller
 */
class PublicController extends AbstractPaginatorController
{

    /**
     * List all posts
     */
    public function indexAction()
    {
        return $this->listPosts();
    }

    /**
     * List all posts of an Author
     */
    public function authorAction($id)
    {
        return $this->listPosts(array(
            'u.id'  => $id,
        ));
    }

    /**
     * List all posts of a category
     */
    public function categoryAction($slug)
    {
        return $this->listPosts(array(
            'c.slug'  => $slug,
        ));
    }

    private function listPosts($conditions = array())
    {
        $em = $this->getDoctrine()->getManager();

        $query = $em->getRepository('AcmeBlogBundle:Post')->findAllQuery($conditions);

        $posts = $this->paginate($query);

        return $this->render('AcmeBlogBundle:Public:index.html.twig', array(
            'posts' => $posts,
        ));
    }
    

    /**
     * Finds and displays a post
     */
    public function showAction($slug)
    {
        $em = $this->getDoctrine()->getManager();

        $post = $em->getRepository('AcmeBlogBundle:Post')->findOneBySlug($slug);

        if (!$post)
            throw $this->createNotFoundException('Unable to find this post.');

        return $this->render('AcmeBlogBundle:Public:show.html.twig', array(
            'post'      => $post,
        ));
    }
}