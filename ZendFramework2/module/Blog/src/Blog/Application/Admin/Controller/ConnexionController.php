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
            $data = $request->getPost();
            $form->setData($data);

            if ($form->isValid()) {
                $user = $this->getEntityManager()->getRepository('Blog\Business\Entity\User')->findOneBy(array(
                    'username' => $user->getUsername(),
                    'password' => sha1($user->getPassword()),
                ));

                if (null == $user) {
                    $this->flashMessenger()->addErrorMessage($this->getTranslation('USER_NOT_FOUND'));

                    return $this->redirect()->toRoute('admin');
                }

                // Init Session

                $this->flashMessenger()->addSuccessMessage($this->getTranslation('FORM_SUCCESS_LOGIN'));

                return $this->redirect()->toRoute('admin');
            } else {
                $this->flashMessenger()->addErrorMessage($this->getTranslation('FORM_ERROR_LOGIN'));
            }
        }

        return array(
            'form' => $form,
        );
    }
}
