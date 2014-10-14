<?php

/**
 * This controller is responsible for adding, listing and deleting users.
 *
 * @todo action list
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
     * Displays all user's posts.
     *
     * @param string|int $id User ID.
     *
     * @throws \EHttpException Thrown if such user or page isn't found (404).
     *
     * @return void
     * @since 0.1.0
     */
    public function actionIndex($id)
    {
        if (($user = \User::model()->with('postCount')->findByPk($id)) === null) {
            throw new \EHttpException(404);
        }
        $user->posts = \Post::model()->paged($this->page->pageNumber)->findAll(
            'user_id = :user_id',
            array(':user_id' => $user->getPrimaryKey())
        );
        if (sizeof($user->posts) === 0 && $this->page->pageNumber > 1) {
            throw new \EHttpException(404);
        }
        $this->page->resetI18n(array('{username}' => $user->username));
        $this->page->totalPages = ceil($user->postCount / 5);
        $data = array('user' => $user, 'posts' => $user->posts,);
        $this->render('posts', $data, $user);
    }

    /**
     * Displays all available users.
     *
     * @return void
     * @since 0.1.0
     */
    public function actionDashboard()
    {
        $users = \User::model()
            ->paged($this->page->pageNumber, 10)
            ->with('postCount')
            ->findAll();
        $this->page->totalPages = \User::model()->totalPages(10);
        $this->render('dashboard', array('users' => $users,));
    }

    /**
     * This action renders new user form on GET request and creates new user
     * on POST request, redirecting to `user/dashboard` page after.
     *
     * @return void
     * @since 0.1.0
     */
    public function actionNew()
    {
        $user = new \User;
        if (($data = \Yii::app()->getRequest()->getPost('User'))) {
            if ($user->setAndSave($data)) {
                $id = $user->getPrimaryKey();
                \Yii::app()->user->sendSuccessMessage(
                    'user.creation.success',
                    array('{user}' => $user->username,)
                );
                $this->redirect(array('user/dashboard', 'created' => $id));
            } else {
                \Yii::app()->user->sendErrorMessage('user.creation.fail');
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
            $data = \Yii::app()->user->getData('user.' . $key);
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
        /** @type \User $user */
        $user = \User::model()->findByPk(\Yii::app()->user->id);
        $user->setScenario('passwordUpdate');
        if (!$data) {
            \Yii::app()->user->sendErrorMessage('profile.passwordUpdate.noData');
        } elseif (!$user->setAndSave($data)) {
            \Yii::app()->user->sendErrorMessage('profile.passwordUpdate.fail');
            \Yii::app()->user->saveData('user.passwordUpdate', $data);
        } else {
            \Yii::app()->user->SendSuccessMessage(
                'profile.passwordUpdate.success'
            );
        }
        $this->redirect(array('user/profile'));
    }

    /**
     * Updates current user's username.
     *
     * @return void
     * @since 0.1.0
     */
    public function actionUpdateUsername()
    {
        $data = \Yii::app()->request->getPost('User');
        /** @type \User $user */
        $user = \User::model()->findByPk(\Yii::app()->user->id);
        $user->setScenario('usernameUpdate');
        if (!$data) {
            \Yii::app()->user->sendErrorMessage('profile.usernameUpdate.noData');
        } elseif ($data['username'] === \Yii::app()->user->username) {
            \Yii::app()->user->sendNotice('profile.usernameUpdate.alreadyOwned');
        } elseif (!$user->updateUsername($data['username'])) {
            \Yii::app()->user->sendErrorMessage('profile.usernameUpdate.fail');
            \Yii::app()->user->saveData('user.usernameUpdate', $data);
        } else {
            \Yii::app()->user->username = $user->username;
            \Yii::app()->user->sendSuccessMessage(
                'profile.usernameUpdate.success'
            );
        }
        $this->redirect(array('user/profile'));
    }

    /**
     * This action renders suicide booth on GET request and deletes current
     * user on POST request (which is achieved by pressing button in suicide
     * booth).
     *
     * @return void
     * @since 0.1.0
     */
    public function actionSuicide()
    {
        if (\Yii::app()->request->isPostRequest) {
            \User::model()->findByPk(\Yii::app()->user->id)->delete();
            \Yii::app()->user->logout(false, true);
            \Yii::app()->user->sendNotice('deletion.goodbye');
            $this->redirect(array('post/index'));
        }
        $this->render('suicide');
    }

    /**
     * Publicly lists available users.
     *
     * @throws \EHttpException Thrown if requested page doesn't contain users
     *                         (404)
     *
     * @return void
     * @since 0.1.0
     */
    public function actionList()
    {
        $users = \User::model()->paged($this->page->pageNumber, 25)->findAll();
        if (!$users && $this->page->pageNumber > 1) {
            throw new \EHttpException(404);
        }
        $this->page->totalPages = \User::model()->count() / 25;
        $this->render('list', array('users' => $users,), $users);
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
            array('allow', 'users' => array('@',),),
            array(
                'allow',
                'users' => array('*',),
                'actions' => array('index', 'list',),
            ),
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

    /**
     * {@inheritdoc}
     *
     * @return string[] List of action ancestors.
     * @since 0.1.0
     */
    public function getActionAncestors()
    {
        return array(
            'index' => 'post/index',
            'dashboard' => 'admin/index',
            'new' => 'dashboard',
            'profile' => 'admin/index',
            'suicide' => 'profile',
            'list' => 'post/index',
        );
    }

    /**
     * {@inheritdoc}
     *
     * @return array Action navigation links definitions.
     * @since 0.1.0
     */
    public function navigationLinks()
    {
        return array(
            'index' => array('list', 'post/index'),
            'new' => array('dashboard', 'admin/index'),
            'list' => array('post/index',),
            'profile' => array('admin/index',),
            'dashboard' => array(
                array(
                    'route' => 'user/new',
                    'type' => 'button',
                    'title' => 'control.createUser',
                    'role' => 'create-user-link'
                ),
            ),
        );
    }
}
