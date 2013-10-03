<?php
/**
 * Blog
 *
 * @link http://www.groupeastek.com
 */
namespace Blog\Core\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Paginator\Paginator;
use Zend\Mvc\MvcEvent;

use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity;

abstract class CoreController extends AbstractActionController
{
    public function onDispatch(MvcEvent $e)
    {
        $this->layout()->cacheDirectory = $this->getCacheDirectory();
        parent::onDispatch($e);
    }

    private $entityManager = null;

    private $config = null;

    private $translator = null;

    public function getEntityManager()
    {
        if (null === $this->entityManager) {
            $this->entityManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }

        return $this->entityManager;
    }

    public function getTranslation($msgid, array $args = array())
    {
        if (null === $this->translator) {
            $this->translator = $this->getServiceLocator()->get('translator');
        }

        return vsprintf($this->translator->translate($msgid), $args);
    }

    public function getConfig()
    {
        if (null === $this->config) {
            $this->config = $this->getServiceLocator()->get('Config');
        }

        return $this->config;
    }

    public function getPaginator($fullEntityClassName, $method, array $params = array())
    {
        $query     = call_user_func_array(array($this->getEntityManager()->getRepository($fullEntityClassName), $method), $params);
        $paginator = new Paginator(new DoctrinePaginator(new ORMPaginator($query)));

        $paginator->setItemCountPerPage(5);
        $paginator->setCurrentPageNumber($this->params()->fromRoute('page'));

        return array(
            'paginator' => $paginator,
            'items'     => $paginator->getCurrentItems(),
        );
    }

    public function getDoctrineEntityHydrator()
    {
        return (new DoctrineEntity($this->getEntityManager()));
    }

    public function getRootDirectory()
    {
        return getcwd() . DIRECTORY_SEPARATOR;
    }

    public function getDataDirectory()
    {
        return $this->getRootDirectory() . DIRECTORY_SEPARATOR . 'data';
    }

    public function getCacheDirectory()
    {
        return $this->getDataDirectory() . DIRECTORY_SEPARATOR . 'cache';
    }
}