<?php

namespace Blog\Factory;

use Blog\Controller\ConnexionController;
use Blog\Form\ConnexionForm;
use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ConnexionControllerFactory implements FactoryInterface
{
    /**
     * @param  ServiceLocatorInterface $serviceLocator
     * @return ConnexionController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $serviceLocator     = $serviceLocator->getServiceLocator();
        $formElementManager = $serviceLocator->get('formElementManager');
        /** @var ConnexionForm $connexionForm */
        $connexionForm = $formElementManager->get('Blog/Form/Connexion');
        /** @var AuthenticationService $authenticationService */
        $authenticationService = $serviceLocator->get('Zend\Authentication\AuthenticationService');
        return new ConnexionController($connexionForm, $authenticationService);
    }
}
