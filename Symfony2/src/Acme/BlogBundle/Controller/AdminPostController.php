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

        $posts = $em->getRepository('AcmeBlogBundle:Post')->findAll();

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


        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($post);
            $em->flush();

            return $this->redirect($this->generateUrl('acme_blog_post_admin'));
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

        if (!$post) {
            throw $this->createNotFoundException('Unable to find this post.');
        }

        $em->remove($post);
        $em->flush();

        return $this->redirect($this->generateUrl('acme_blog_post_admin'));
    }
}
