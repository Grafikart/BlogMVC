<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Blog\Application\Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Blog\Core\Controller\CoreController;
use Blog\Application\Admin\Form\ConnexionForm;
use Blog\Business\Entity\User;

class ConnexionController extends CoreController
{
    public function indexAction()
    {
        $request = $this->getRequest();
        $form    = new ConnexionForm();
        $user = new User();

        $form->bind($user);

        if ($request->isPost()) {
            $data = $request->getPost()->toArray();
            $form->setData($data);

            if ($form->isValid()) {
                $auth = $this->getServiceLocator()->get('doctrine.authenticationservice.orm_default');
                $auth->getAdapter()->setIdentityValue($data['username']);
                $auth->getAdapter()->setCredentialValue($data['password']);
                $result = $auth->authenticate();

                if ($auth->hasIdentity()) {
                    $this->flashMessenger()->addSuccessMessage($this->getTranslation('FORM_SUCCESS_LOGIN'));

                    return $this->redirect()->toRoute('admin/posts');
                } else {
                    $this->flashMessenger()->addErrorMessage($this->getTranslation('FORM_ERROR_LOGIN'));
                }
            } else {
                $this->flashMessenger()->addErrorMessage($this->getTranslation('FORM_ERROR_LOGIN'));
            }
        }

        return array(
            'form' => $form,
        );
    }

    public function logoutAction()
    {
        $auth = $this->getServiceLocator()->get('doctrine.authenticationservice.orm_default');
        $auth->clearIdentity();

        return $this->redirect()->toRoute('home');
    }
}
