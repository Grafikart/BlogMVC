<?php
namespace Acme\UserBundle\DataFixtures\ORM;

use Acme\UserBundle\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $factory = $this->container->get('security.encoder_factory');

        // Create Admin User
        $userAdmin = new User();
        $encoder = $factory->getEncoder($userAdmin);
        $userAdmin
            ->setUsername('admin')
            ->setEmail('admin@blogmvc.com')
            ->setPassword($encoder->encodePassword('admin', $userAdmin->getSalt()))
        ;

        $userAdmin->addRole('ROLE_ADMIN');

        $manager->persist($userAdmin);
        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1;
    }
}
