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
        $this->layout = 'form';
        $this->pageTitle = 'Login';
        if (($data = Yii::app()->request->getPost('User', false)) !== false) {
            $identity = new UserIdentity($data['username'], $data['password']);
            if ($identity->authenticate()) {
                Yii::app()->user->login($identity);
                Yii::app()->user->sendMessage('auth.login.greeting');
                $this->redirect(array('admin/index'));
            } else {
                Yii::app()->user->sendMessage('auth.login.fail');
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
            Yii::app()->user->sendMessage('auth.logout.guestAttempt');
        } else {
            Yii::app()->user->logout();
            Yii::app()->user->sendMessage('auth.logout.goodbye');
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
        $model = User::model();
        if ($data = Yii::app()->request->getPost('User')) {
            if ($model->save(true, $data)) {
                Yii::app()->user->sendMessage('invite.success');
                $this->redirect('admin/index');
            } else {
                Yii::app()->user->sendMessage('invite.fail');
            }
        }
        $this->render('invite', array('userModel' => $model));
    }
    public function actionHelp()
    {
        $this->render('help.md');
    }
    public function actionDevHelp()
    {
        $this->render('help-dev.md');
    }
    public function actionStatus()
    {
        $service = Yii::app()->applicationService;
        $this->render('status', array(
            'statistics' => ApplicationModel::getStatistics(),
            'status' => $service->getServiceInfo()
        ));
    }
    public function actionOptions()
    {
        $model = new ApplicationModel;
        if ($data = Yii::app()->request->getPost('ApplicationModel', false)) {
            $model->setAttributes($data);
            if ($model->validate()) {
                $model->updateConfig();
            }
        }
        $this->render('options', array('applicationModel' => $model));
    }
    public function actionFlushCache()
    {
        Yii::app()->cache->flush();
        Yii::app()->user->sendMessage('cache.afterFlush');
        $this->redirect(array('admin/options'));
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
