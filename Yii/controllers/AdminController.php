<?php

/**
 * Description of AdminController
 *
 * @author Fike Etki <etki@etki.name>
 * @version 0.1.0
 * @since 0.1.0
 * @package blogmvc
 * @subpackage yii
 */
class AdminController extends BaseController
{
    public function actionIndex()
    {
        $this->render('index');
    }
    public function actionLogin()
    {
        if (($data = Yii::app()->request->getPost('User', false)) !== false) {
            $identity = new UserIdentity($data['username'], $data['password']);
            if ($identity->authenticate()) {
                Yii::app()->user->login($identity);
                Yii::app()->user->sendMessage('after-login');
                $this->redirect(array('admin/index'));
            } else {
                Yii::app()->user->sendMessage('failed-login');
            }
        }
        $model = User::model();
        $model->scenario = 'login';
        if (isset($data)) {
            $model->addErrors(array('username' => '', 'password' => ''));
        }
        $this->render('login', array('userModel' => $model));
    }
    public function actionLogout()
    {
        if (Yii::app()->user->isGuest) {
            Yii::app()->user->sendMessage('guest-logout');
        } else {
            Yii::app()->user->sendMessage('after-logout');
            Yii::app()->user->logout();
        }
        $this->redirect(array('post/index'));
    }
    public function actionProfile()
    {
        $model = User::model();
        $model->scenario = 'update';
        if (Yii::app()->request->getPost('User', false) !== false) {}
        $this->render('profile', array('userModel' => $model));
    }
    public function actionDeleteProfile()
    {
        if (Yii::app()->request->isPostRequest) {
            Yii::app()->user->sendMessage('after-delete');
            $this->redirect(array('post/index'));
        }
        $this->render('delete-profile');
    }
    public function actionInvite()
    {
        
    }
    public function actionHelp()
    {
        $this->render('help.md');
    }
    public function actionStatus()
    {
        $service = Yii::app()->applicationService;
        $this->render('status', array('status' => $service->getData()));
    }
    public function filters() {
        return array(
            'accessControl',
        );
    }
    public function accessRules() {
        return array(
            array('allow', 'actions' => array('login')),
            array('deny', 'actions' => array('*'), 'users' => array('?')),
        );
    }
}
