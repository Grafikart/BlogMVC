<?php

/**
 * Main controller that handles some general actions like login/logout and error
 * display.
 *
 * @version    Release: 0.1.0
 * @since      0.1.0
 * @package    BlogMVC
 * @subpackage Yii
 * @author     Fike Etki <etki@etki.name>
 */
class SiteController extends \BaseController
{
    /**
     * Renders login form and processes incoming logins.
     *
     * @return void
     * @since 0.1.0
     */
    public function actionLogin()
    {
        if (!\Yii::app()->user->getIsGuest()) {
            \Yii::app()->user->sendNotice('auth.login.alreadyAuthorized');
            $this->redirect(array('admin/index'));
        }
        $model = \User::model();
        if ($data = \Yii::app()->request->getPost('User')) {
            $identity = new \UserIdentity($data['username'], $data['password']);
            $identity->authenticate();
            if (\Yii::app()->user->login($identity)) {
                $returnUrl = \Yii::app()->user->returnUrl;
                if ($returnUrl && $returnUrl !== '/') {
                    $this->redirect($returnUrl);
                }
                $this->redirect(array('admin/index'));
            } else {
                $model->addErrors(array('username' => '', 'password' => ''));
            }
        }
        $this->render('login', array('user' => $model));
    }

    /**
     * Logs out user and pushes him to main page.
     *
     * @return void
     * @since 0.1.0
     */
    public function actionLogout()
    {
        \Yii::app()->user->logout();
        $this->redirect(array('post/index'));
    }

    /**
     * This action displays errors, whateva.
     *
     * @throws \EHttpException Throws exception if can't find error resulting in
     * another call displaying 404 page.
     *
     * @return void
     * @since 0.1.0
     */
    public function actionError()
    {
        $error = \Yii::app()->errorHandler->error;
        if (!$error) {
            throw new \EHttpException(404);
        }
        $this->page->resetI18n(array('{errorCode}' => $error['code'],));
        $this->page->format = 'html';
        $this->render('error', $error);
    }

    /**
     * {@inheritdoc}
     *
     * @return string[] List of action ancestors.
     * @since 0.1.0
     */
    public function getActionAncestors()
    {
        return array(
            'login' => 'post/index',
            'error' => 'post/index',
        );
    }
}
