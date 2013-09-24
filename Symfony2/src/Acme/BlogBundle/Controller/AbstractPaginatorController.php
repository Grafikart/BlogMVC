<?php

namespace Acme\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * Abstract controller
 */
abstract class AbstractPaginatorController extends Controller
{
    protected function paginate($query, $limit = 5){
        $request = $this->getRequest();
        $page = (int) $request->get('page') ?: 1;

        $query
            ->setFirstResult(($page-1) * $limit)
            ->setMaxResults($limit)
        ;

        return new Paginator($query, true);
    }
}