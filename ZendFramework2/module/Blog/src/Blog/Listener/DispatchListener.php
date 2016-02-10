<?php

namespace Blog\Listener;

use Blog\Service\CacheService;
use Zend\Authentication\AuthenticationService;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\Controller\Plugin\Layout;
use Zend\Mvc\Controller\Plugin\Redirect;
use Zend\Mvc\MvcEvent;

class DispatchListener extends AbstractListenerAggregate
{
    /** @var  CacheService */
    private $cacheService;

    /** @var AuthenticationService  */
    private $authenticationService;

    public function __construct(CacheService $cacheService, AuthenticationService $authenticationService)
    {
        $this->cacheService          = $cacheService;
        $this->authenticationService = $authenticationService;
    }

    /**
     * @var \Zend\Stdlib\CallbackHandler[]
     */
    protected $listeners = array();

    /**
     * Attach one or more listeners
     *
     * Implementors may add an optional $priority argument; the EventManager
     * implementation will pass this to the aggregate.
     *
     * @param EventManagerInterface $events
     */
    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_RENDER, array($this, 'addCacheDirectory'));
        $this->listeners[] = $events->attach(MvcEvent::EVENT_RENDER, array($this, 'secureAdminRoute'));
    }

    public function addCacheDirectory(MvcEvent $e)
    {
        $e->getViewModel()->setVariable('cacheDirectory', $this->cacheService->getCacheDirectory());
    }

    public function secureAdminRoute(MvcEvent $e)
    {
        $sm   = $e->getApplication()->getServiceManager();

        if (0 === strpos($e->getRouteMatch()->getMatchedRouteName(), 'admin')) {
            /** @var Layout $layout */
            $layout = $sm->get('ControllerPluginManager')->get('Layout');
            $layout->setTemplate('admin/layout');
            /** @var Redirect $redirector */
            $redirector = $sm->get('ControllerPluginManager')->get('Redirect');

            if ('admin' == $e->getRouteMatch()->getMatchedRouteName() && $this->authenticationService->hasIdentity()) {
                $redirector->toRoute('admin/posts');
            }

            if ('admin' != $e->getRouteMatch()->getMatchedRouteName() && !$this->authenticationService->hasIdentity()) {
                $redirector->toRoute('admin');
            }
        }
    }
}
