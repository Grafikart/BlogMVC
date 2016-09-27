<?php

namespace Acme\BlogBundle\Controller;

use Doctrine\Common\Cache\ApcCache;
use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Abstract controller
 */
abstract class AbstractController extends Controller
{
    /**
     * @param $query
     * @param int $limit
     * @return Paginator
     */
    protected function paginate($query, $limit = 5)
    {
        $request = $this->getRequest();
        $page = (int) $request->get('page') ?: 1;

        $query
            ->setFirstResult(($page-1) * $limit)
            ->setMaxResults($limit)
        ;

        return new Paginator($query, true);
    }

    /**
     * Select the best cache
     */
    protected function getCache()
    {
        return function_exists('apc_fetch')
            ? new ApcCache()
            : new FilesystemCache('../app/cache/filecache')
        ;
    }
}
