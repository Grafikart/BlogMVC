<?php

namespace Acme\BlogBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

use Acme\BlogBundle\Controller\AbstractController,
    Acme\BlogBundle\Entity\Post,
    Acme\BlogBundle\Form\PostType;

/**
 * Admin Post controller
 */
class AdminPostController extends AbstractController
{
    /**
     * List all posts
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $query = $em->getRepository('AcmeBlogBundle:Post')->findAllQuery();

        $posts = $this->paginate($query);

        return $this->render('AcmeBlogBundle:AdminPost:index.html.twig', array(
            'posts' => $posts,
        ));
    }


    /**
     * Create or Edit a Post
     */
    public function manageAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        if($id !== null){
            $post = $em->getRepository('AcmeBlogBundle:Post')->find($id);

            if (!$post)
                throw $this->createNotFoundException('Unable to find this post.');
        } else {
            $post = new Post();
        }

        // Create form
        $form = $this->createForm(new PostType(), $post, array(
            'action' => $this->generateUrl('acme_blog_post_manage', array('id' => $post->getId())),
            'method' => 'POST',
        ));

        // If it's a submit, valid and save
        if('POST' == $request->getMethod()){
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em->persist($post);
                $em->flush();

                // New post : update post count
                if($post->getId() == null)
                    $this->updateCategoryPostCount($post->getCategory());

                return $this->redirectAdmin();
            }
        }

        return $this->render('AcmeBlogBundle:AdminPost:manage.html.twig', array(
            'post'  => $post,
            'form'  => $form->createView(),
        ));
    }

    /**
     * Delete a post
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository('AcmeBlogBundle:Post')->find($id);

        if (!$post)
            throw $this->createNotFoundException('Unable to find this post.');

        $em->remove($post);
        $em->flush();

        $this->clearCache();

        return $this->redirectAdmin();
    }


    /**
     * Custom redirect helper to admin index
     */
    protected function redirectAdmin()
    {
        return $this->redirect($this->generateUrl('acme_blog_post_admin'));
    }

    /**
     * Update countPost on a category
     */
    protected function clearCache()
    {
        $this->getCache()->delete('acme_blog_sidebar');
    }
}