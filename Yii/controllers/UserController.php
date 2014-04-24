<?php

/**
 * This controller is responsible for adding, listing and deleting users.
 *
 * @version    Release: 0.1.0
 * @since      0.1.0
 * @package    BlogMVC
 * @subpackage Yii
 * @author     Fike Etki <etki@etki.name>
 */
class UserController extends BaseController
{
    /**
     * This action renders new user form on GET request and creates new user
     * on POST request, redirecting to `user/index` page after.
     *
     * @return void
     * @since 0.1.0
     */
    public function actionNew()
    {
        $user = new \User;
        if (($data = \Yii::app()->request->getPost('User'))) {
            if ($user->setAndSave($data)) {
                $id = $user->getPrimaryKey();
                \Yii::app()->user->sendMessage(
                    'user.creation.success',
                    \WebUserLayer::FLASH_SUCCESS,
                    array('{user}' => $user->username,)
                );
                $this->redirect(array('user/index', 'created' => $id));
            } else {
                \Yii::app()->user->sendMessage(
                    'user.creation.fail',
                    \WebUserLayer::FLASH_ERROR
                );
            }
        }
        $this->render('new', array('user' => $user));
    }
    /**
     * This action renders profile and optionally updates user profile on POST
     * request.
     *
     * @return void
     * @since 0.1.0
     */
    public function actionProfile()
    {
        $user = \User::model()->findByPk(\Yii::app()->user->id);
        foreach (array('usernameUpdate', 'passwordUpdate') as $key) {
            $data = \Yii::app()->user->getData('user.'.$key);
            if ($data !== null) {
                $user->setScenario($key);
                $user->setAttributes($data);
                $user->validate();
            }
        }
        $this->render('profile', array('user' => $user,));
    }

    /**
     * Updates user password.
     *
     * @return void
     * @since 0.1.0
     */
    public function actionUpdatePassword()
    {
        $data = \Yii::app()->request->getPost('User');
        $user = \User::model()->findByPk(\Yii::app()->user->id);
        $user->setScenario('passwordUpdate');
        if (!$data) {
            \Yii::app()->user->sendMessage(
                'profile.passwordUpdate.noData',
                \WebUserLayer::FLASH_ERROR
            );
        } elseif (!$user->setAndSave($data)) {
            \Yii::app()->user->sendMessage(
                'profile.passwordUpdate.fail',
                \WebUserLayer::FLASH_ERROR
            );
            \Yii::app()->user->saveData('user.passwordUpdate', $data);
        } else {
            \Yii::app()->user->sendMessage(
                'profile.passwordUpdate.success',
                \WebUserLayer::FLASH_SUCCESS
            );
        }
        $this->redirect(array('user/profile'));
    }
    public function actionUpdateUsername()
    {
        $data = \Yii::app()->request->getPost('User');
        $user = \User::model()->findByPk(\Yii::app()->user->id);
        $user->setScenario('usernameUpdate');
        if (!$data) {
            \Yii::app()->user->sendMessage(
                'profile.usernameUpdate.noData',
                \WebUserLayer::FLASH_ERROR
            );
        } elseif ($data['username'] === \Yii::app()->user->username) {
            \Yii::app()->user->sendMessage(
                'profile.usernameUpdate.alreadyOwned',
                \WebUserLayer::FLASH_NOTICE
            );
        } elseif (!$user->setAndSave($data)) {
            \Yii::app()->user->sendMessage(
                'profile.usernameUpdate.fail',
                \WebUserLayer::FLASH_ERROR
            );
            \Yii::app()->user->saveData('user.usernameUpdate', $data);
        } else {
            \Yii::app()->user->username = $user->username;
            \Yii::app()->user->sendMessage(
                'profile.usernameUpdate.success',
                \WebUserLayer::FLASH_SUCCESS
            );
        }
        $this->redirect(array('user/profile'));
    }
    /**
     * This action renders suicide booth on GET request and deletes current
     * user on POST request (which is achieved by pressing button in suicide
     * booth).
     * 
     * @todo Final message is not displayed yet
     *
     * @return void
     * @since 0.1.0
     */
    public function actionSuicide()
    {
        if (\Yii::app()->request->isPostRequest) {
            $user = \User::model()->findByPk(\Yii::app()->user->id);
            $user->delete();
            \Yii::app()->user->logout();
            \Yii::app()->user->sendMessage('deletion.goodbye');
            $this->redirect(array('post/index'));
        }
        $this->render('suicide');
    }
    /**
     * Renders login form and processes incoming logins.
     *
     * @return void
     * @since 0.1.0
     */
    public function actionLogin()
    {
        $this->pageTitle = 'Login';
        $model = \User::model();
        if (!\Yii::app()->user->getIsGuest()) {
            \Yii::app()->user->sendMessage('auth.login.alreadyAuthorized');
            $this->redirect(array('admin/index'));
        }
        if (($data = \Yii::app()->request->getPost('User', false)) !== false) {
            $identity = new \UserIdentity($data['username'], $data['password']);
            if ($identity->authenticate()) {
                \Yii::app()->user->login($identity);
                \Yii::app()->user->sendMessage(
                    'auth.login.greeting',
                    \WebUserLayer::FLASH_SUCCESS
                );
                $returnUrl = \Yii::app()->user->returnUrl;
                if (!empty($returnUrl) && $returnUrl !== '/') {
                    $this->redirect($returnUrl);
                }
                $this->redirect(array('admin/index'));
            } else {
                \Yii::app()->user->sendMessage(
                    'auth.login.fail',
                    \WebUserLayer::FLASH_ERROR
                );
            }
        }
        if ($data) {
            $model->addErrors(array('username' => '', 'password' => ''));
        }
        $this->render('login', array('user' => $model));
    }

    /**
     * Logouts user and pushes him to main page.
     *
     * @todo Finally do something with not-saving messages after logout
     *
     * @return void
     * @since 0.1.0
     */
    public function actionLogout()
    {
        if (\Yii::app()->user->getIsGuest()) {
            \Yii::app()->user->sendMessage(
                'auth.logout.guestAttempt',
                \WebUserLayer::FLASH_NOTICE
            );
        } else {
            \Yii::app()->user->sendMessage(
                'auth.logout.goodbye',
                \WebUserLayer::FLASH_NOTICE
            );
            \Yii::app()->user->logout();
        }
        $this->redirect(array('post/index'));
    }

    /**
     * Displays all available users.
     *
     * @param int|string $page Current page number.
     *
     * @return void
     * @since 0.1.0
     */
    public function actionIndex($page=1)
    {
        $page = $this->setPageNumber($page);
        $users = \User::model()->paged($page, 25)->with('postCount')->findAll();
        $this->render(
            'index',
            array(
                'users' => $users,
                'pagination' => array(
                    'currentPage' => $page,
                    'totalPages' => \User::model()->count() / 25,
                    'route' => 'post/user',
                ),
            )
        );
    }

    /**
     * Defines action access rules.
     *
     * @return array Set of access rules.
     * @since 0.1.0
     */
    public function accessRules()
    {
        return array(
            array('allow', 'actions' => array('login','logout',),),
            array('allow', 'users' => array('@'),),
            array('deny',),
        );
    }

    /**
     * Returns list of controller filters.
     *
     * @return array List of controller filters.
     * @since 0.1.0
     */
    public function filters()
    {
        return array('accessControl');
    }
}
