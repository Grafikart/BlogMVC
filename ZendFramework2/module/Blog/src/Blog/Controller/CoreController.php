<?php
/**
 * Blog
 *
 * @link http://www.groupeastek.com
 */
namespace Blog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Paginator\Paginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;

abstract class CoreController extends AbstractActionController
{
    private $entityManager = null;

    private $config = null;

    public function getEntityManager()
    {
        if (null === $this->entityManager) {
            $this->entityManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }

        return $this->entityManager;
    }

    public function getConfig()
    {
        if (null === $this->config) {
            $this->config = $this->getServiceLocator()->get('Config');
        }

        return $this->config;
    }

    public function getPaginator($fullEntityClassName, $method)
    {
        $query     = $this->getEntityManager()->getRepository($fullEntityClassName)->$method();
        $paginator = new Paginator(new DoctrinePaginator(new ORMPaginator($query)));

        $paginator->setItemCountPerPage(5);
        $paginator->setCurrentPageNumber($this->params()->fromRoute('page'));

        return $paginator;
    }
}