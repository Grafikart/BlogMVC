<?php

namespace Acme\BlogBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Acme\BlogBundle\Entity\Post;
use Acme\BlogBundle\Form\PostType;

/**
 * Admin Post controller
 */
class AdminPostController extends Controller
{
    /**
     * List all posts
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $posts = $em->getRepository('AcmeBlogBundle:Post')->findAll(array(), array('id' => 'desc'));

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
            'action' => $this->generateUrl('acme_blog_post_manage'),
            'method' => 'POST',
        ));

        // If it's a submit, valid and save
        if('POST' == $request->getMethod()){
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em->persist($post);
                $em->flush();

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

        return $this->redirectAdmin();
    }


    /**
     * Custom redirect helper to admin index
     */
    public function redirectAdmin()
    {
        return $this->redirect($this->generateUrl('acme_blog_post_admin'));
    }
}