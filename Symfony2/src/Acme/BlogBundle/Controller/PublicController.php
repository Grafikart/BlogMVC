<?php

namespace Acme\BlogBundle\Controller;

use Acme\BlogBundle\Entity\Comment;
use Acme\BlogBundle\Form\CommentType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Public controller
 */
class PublicController extends AbstractController
{
    /**
     * List all posts
     *
     * @param Request $request
     */
    public function indexAction(Request $request)
    {
        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $posts = $em->getRepository('AcmeBlogBundle:Post')
            ->allPosts($this->get('knp_paginator'), $request->get('page', 1), 10);

        return $this->render('AcmeBlogBundle:Public:index.html.twig', array(
            'posts' => $posts,
        ));
    }

    /**
     * List all posts of an Author
     *
     * @param int $id
     * @param Request $request
     */
    public function authorAction($id, Request $request)
    {
        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $posts = $em->getRepository('AcmeBlogBundle:Post')
            ->authorPosts($id, $this->get('knp_paginator'), $request->get('page', 1), 10);

        return $this->render('AcmeBlogBundle:Public:index.html.twig', array(
            'posts' => $posts,
        ));
    }

    /**
     * List all posts of a category
     *
     * @param string $slug
     */
    public function categoryAction($slug)
    {
        return $this->listPosts(array(
            'c.slug'  => $slug,
        ));
    }

    /**
     * @param array $conditions
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
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
     *
     * @param string $slug
     */
    public function showAction($slug)
    {
        $em = $this->getDoctrine()->getManager();

        $post = $em->getRepository('AcmeBlogBundle:Post')->findOneBySlug($slug);

        if (! $post) {
            throw $this->createNotFoundException('Unable to find this post.');
        }

        $request = $this->getRequest();

        // Create form
        $comment = new Comment();
        $comment->setPost($post);
        $form = $this->createForm(new CommentType(), $comment, array(
            'method' => 'POST',
        ));

        // If it's a submit, valid and save the comment
        if ('POST' == $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em->persist($comment);
                $em->flush();

                return $this->redirect($request->headers->get('referer') . '#comments');
            }
        }

        return $this->render('AcmeBlogBundle:Public:show.html.twig', array(
            'post'  => $post,
            'form'  => $form->createView(),
        ));
    }

    /**
     * Sidebar action
     */
    public function sidebarAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cache = $this->getCache();

        if ($cache->contains('acme_blog_sidebar')) {
            $sidebar = $cache->fetch('acme_blog_sidebar');
        } else {
            $categories = $em->getRepository('AcmeBlogBundle:Category')->findAllWithCount();
            $posts = $em->getRepository('AcmeBlogBundle:Post')->findLast(2);

            $sidebar = $this->render('AcmeBlogBundle:Public:sidebar.html.twig', array(
                'categories'    => $categories,
                'posts'         => $posts,
            ));

            $cache->save('acme_blog_sidebar', $sidebar);
        }

        return $sidebar;
    }
}
