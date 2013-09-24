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
     *
     * 0 => post_id
     * 1 => username
     * 2 => mail
     * 3 => content
     * 4 => created
     */
    private $commentsData = array(
        array(6, 'User #1', 'contact@test.fr', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vero, laudantium voluptatibus quae doloribus dolorem earum dicta quasi. Fugit, eligendi, voluptatibus corporis deleniti perferendis accusantium totam harum dolor ab veniam laudantium!', '2013-09-22 19:45:53'),
        array(6, 'User #2', 'contact@wordpress.com', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vero, laudantium voluptatibus quae doloribus dolorem earum dicta quasi. Fugit, eligendi, voluptatibus corporis deleniti perferendis accusantium totam harum dolor ab veniam laudantium!', '2013-09-22 19:46:11'),
        array(6, 'User #3', 'contact@lol.fr', 'Hi ! \r\nThis is my first comment !', '2013-09-22 20:07:42')
    );


    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {

        // Create comments
        foreach($this->commentsData as $commentData){
            $comment = new Comment();

            $post = $manager->getRepository('AcmeBlogBundle:Post')->find($commentData[0]);

            $comment
                ->setPost($post)
                ->setUsername($commentData[1])
                ->setMail($commentData[2])
                ->setContent($commentData[3])
                ->setCreated(new \DateTime($commentData[4]))
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