<?php

namespace Blog\Service;

use Blog\Repository\CategoryRepository;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryService
{

    /** @var ObjectManager */
    private $em;

    public function __construct(ObjectManager $em)
    {
        $this->em = $em;
    }

    public function getAllOrdered($order = 'ASC')
    {
        return $this->getRepository()->findBy(array(), array('name' => $order));
    }

    /**
     * @return CategoryRepository
     */
    public function getRepository()
    {
        return $this->em->getRepository('Blog\Entity\Category');
    }
}
