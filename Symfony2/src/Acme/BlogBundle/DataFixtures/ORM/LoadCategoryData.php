<?php
namespace Acme\BlogBundle\DataFixtures\ORM;

use Acme\BlogBundle\Entity\Category;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class LoadCategoryData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        // Create 3 categories
        for ($i = 1; $i < 4; $i++) {
            $category = new Category();
            $category->setName('Category #' . $i);

            $manager->persist($category);
        }

        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 10;
    }
}
