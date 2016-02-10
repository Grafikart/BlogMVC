<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Blog;

use Blog\Listener\DispatchListener;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\FormElementProviderInterface;
use Zend\ModuleManager\Feature\ViewHelperProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\ServiceManager;

class Module implements
    BootstrapListenerInterface,
    ConfigProviderInterface,
    AutoloaderProviderInterface,
    FormElementProviderInterface,
    ViewHelperProviderInterface
{
    public function onBootstrap(EventInterface $event)
    {
        /* @var $application \Zend\Mvc\Application */
        $application         = $event->getTarget();
        /** @var $serviceManager ServiceManager */
        $serviceManager      = $application->getServiceManager();
        $eventManager        = $application->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $eventManager->attachAggregate($serviceManager->get('Blog\Listener\Dispatch'));
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                    'Michelf'     => __DIR__ . '/lib/Michelf'
                ),
            ),
        );
    }

    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'flashMessages' => function ($sm) {
                    $flashmessenger = $sm->getServiceLocator()
                        ->get('ControllerPluginManager')
                        ->get('flashmessenger');

                    $messages = new \Blog\View\Helper\FlashMessages();
                    $messages->setFlashMessenger($flashmessenger);

                    return $messages;
                },
            ),
        );
    }

    /**
     * @return array|\Zend\ServiceManager\Config
     *
     * Add formElementConfig
     */
    public function getFormElementConfig()
    {
        return array(
            /**
             * Add initializers to inject ObjectManager in all form that implement ObjectManagerAwareInterface to use
             * doctrine feature in form
             */
            'initializers' => array(
                'ObjectManagerInitializer' => function ($element, $formElements) {
                    if ($element instanceof ObjectManagerAwareInterface) {
                        $services = $formElements->getServiceLocator();
                        $entityManager = $services->get('orm_em');

                        $element->setObjectManager($entityManager);
                    }
                },
            ),
        );
    }
}
