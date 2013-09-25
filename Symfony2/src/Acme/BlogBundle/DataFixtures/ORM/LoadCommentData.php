<?php
namespace Acme\BlogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture,
    Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Acme\BlogBundle\Entity\Comment;

class LoadCommentData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Comments to save
     */
    private $commentsData = array(
        array(
            'post'      => 'the-route-of-all-evil', 
            'username'  => 'User #1', 
            'mail'      => 'contact@test.fr', 
            'content'   => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vero, laudantium voluptatibus quae doloribus dolorem earum dicta quasi. Fugit, eligendi, voluptatibus corporis deleniti perferendis accusantium totam harum dolor ab veniam laudantium!',
            'created'   => '2013-09-22 19:45:53',
        ),
        array(
            'post'      => 'the-route-of-all-evil', 
            'username'  => 'User #2', 
            'mail'      => 'contact@wordpress.com', 
            'content'   => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vero, laudantium voluptatibus quae doloribus dolorem earum dicta quasi. Fugit, eligendi, voluptatibus corporis deleniti perferendis accusantium totam harum dolor ab veniam laudantium!',
            'created'   => '2013-09-22 19:46:11',
        ),
        array(
            'post'      => 'the-route-of-all-evil', 
            'username'  => 'User #3', 
            'mail'      => 'contact@lol.fr', 
            'content'   => 'Hi !
This is my first comment !', 
            'created'   => '2013-09-22 20:07:42',
        )
    );


    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {

        // Create comments
        foreach($this->commentsData as $commentData){
            $comment = new Comment();

            $post = $manager->getRepository('AcmeBlogBundle:Post')->findOneBySlug($commentData['post']);

            $comment
                ->setPost($post)
                ->setUsername($commentData['username'])
                ->setMail($commentData['mail'])
                ->setContent($commentData['content'])
                ->setCreated(new \DateTime($commentData['created']))
            ;

            $manager->persist($comment);
        }

        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 15;
    }
}