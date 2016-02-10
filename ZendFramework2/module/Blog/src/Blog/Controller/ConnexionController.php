<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Blog\Controller;

use Zend\Authentication\AuthenticationService;
use Zend\View\Model\ViewModel;
use Blog\Form\ConnexionForm;
use Blog\Entity\User;

class ConnexionController extends CoreController
{
    /**
     * @var ConnexionForm
     */
    private $connexionForm;

    /** @var AuthenticationService */
    private $authenticationService;

    public function __construct(ConnexionForm $connexionForm, AuthenticationService $authenticationService)
    {
        $this->connexionForm         = $connexionForm;
        $this->authenticationService = $authenticationService;
    }

    public function indexAction()
    {
        $request = $this->getRequest();
        $user = new User();

        $this->connexionForm->bind($user);

        if ($request->isPost()) {
            $data = $request->getPost();
            $this->connexionForm->setData($data);

            if ($this->connexionForm->isValid()) {
                /** @var User $user */
                $user = $this->connexionForm->getData();
                $adapter = $this->authenticationService->getAdapter();
                $adapter->setIdentityValue($user->getUsername());
                $adapter->setCredentialValue($user->getPassword());
                $result = $this->authenticationService->authenticate();

                if ($result->isValid()) {
                    $this->flashMessenger()->addSuccessMessage($this->getTranslation('FORM_SUCCESS_LOGIN'));

                    return $this->redirect()->toRoute('admin/posts');
                }
            }

            $this->flashMessenger()->addErrorMessage($this->getTranslation('FORM_ERROR_LOGIN'));
            return $this->redirect()->toRoute('admin');
        }

        return new ViewModel(array(
            'form' => $this->connexionForm,
        ));
    }

    public function logoutAction()
    {
        if ($this->identity()) {
            $this->authenticationService->clearIdentity();
        }

        return $this->redirect()->toRoute('home');
    }
}
