<?php
/**
 * Blog
 *
 * @link http://www.groupeastek.com
 */
namespace Blog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Paginator\Paginator;
use Zend\Mvc\MvcEvent;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity;

abstract class CoreController extends AbstractActionController
{
    private $translator = null;

    public function getTranslation($msgid, array $args = array())
    {
        if (null === $this->translator) {
            $this->translator = $this->getServiceLocator()->get('translator');
        }

        return vsprintf($this->translator->translate($msgid), $args);
    }
}
