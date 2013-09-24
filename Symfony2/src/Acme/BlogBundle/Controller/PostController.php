<?php

namespace Acme\BlogBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Acme\BlogBundle\Entity\Post;
use Acme\BlogBundle\Form\PostType;

/**
 * Post controller.
 *
 */
class PostController extends Controller
{

    /**
     * Lists all Post entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AcmeBlogBundle:Post')->findAll();

        return $this->render('AcmeBlogBundle:Post:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    

    /**
     * Finds and displays a Post entity.
     *
     */
    public function showAction($slug)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeBlogBundle:Post')->findBySlug($slug);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Post entity.');
        }

        return $this->render('AcmeBlogBundle:Post:show.html.twig', array(
            'entity'      => $entity,
        ));
    }
}
