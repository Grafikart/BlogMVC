<?php

/**
 * This controller handles all actions related to admin sections except for
 * posts and user managing,
 *
 * @version    Release: 0.1.0
 * @since      0.1.0
 * @package    BlogMVC
 * @subpackage Yii
 * @author     Fike Etki <etki@etki.name>
 */
class AdminController extends BaseController
{
    /**
     * Renders main admin menu.
     *
     * @return void
     * @since 0.1.0
     */
    public function actionIndex()
    {
        $user = \User::model()
            ->with('postCount', 'commentCount')
            ->findByPk(\Yii::app()->user->id);
        $this->render('index', array('user' => $user));
    }

    /**
     * Renders standard help file.
     *
     * @return void
     * @since 0.1.0
     */
    public function actionHelp()
    {
        $this->renderMd('help', 'application.docs.help');
    }

    /**
     * Renders developers help file.
     *
     * @return void
     * @since 0.1.0
     */
    public function actionDevHelp()
    {
        $this->renderMd('help', 'application.docs.help-dev');
    }

    /**
     * Renders application status.
     *
     * @return void
     * @since 0.1.0
     */
    public function actionStatus()
    {
        $data = array(
            'statistics' => \ApplicationModel::getStatistics(),
            'status' => \Yii::app()->applicationService->getServiceInfo(),
        );
        $this->render('status', $data);
    }

    /**
     * Renders options page and saves passed options.
     *
     * @return void
     * @since 0.1.0
     */
    public function actionOptions()
    {
        $model = new \ApplicationModel;
        if ($data = \Yii::app()->request->getPost('ApplicationModel', false)) {
            $model->save($data); // setAndSave analog, errors fetched in view
            // resetting page title after language switch
            $this->page->resetTitle();
        }
        $this->render('options', array('appModel' => $model));
    }

    /**
     * Flushes all cache and redirects user to options page.
     *
     * @param string $returnUrl Optional URL where user should be redirected
     * after cache flushing.
     *
     * @return void
     * @since 0.1.0
     */
    public function actionFlushCache($returnUrl=null)
    {
        \Yii::app()->cache->flush();
        \Yii::app()->user->sendSuccessMessage('cache.afterFlush');
        $this->redirect($returnUrl ? $returnUrl : array('admin/options'));
    }

    /**
     * Recalculates category counters.
     *
     * @return void
     * @since 0.1.0
     */
    public function actionRecalculate()
    {
        \Category::model()->recalculateCounters();
        \Yii::app()->user->sendSuccessMessage('category.recalculated');
        \Yii::app()->cacheHelper->invalidatePostsCache();
        $this->redirect(array('admin/options'));
    }

    /**
     * Defines controller filters.
     *
     * @return array List of filters.
     * @since 0.1.0
     */
    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    /**
     * Returns access control rules.
     *
     * @return array Set of access control rules.
     * @since 0.1.0
     */
    public function accessRules()
    {
        return array(
            array('allow', 'users' => array('@'),),
            array('deny',),
        );
    }

    /**
     * {@inheritdoc}
     *
     * @return string[]
     * @since 0.1.0
     */
    public function getActionAncestors()
    {
        return array(
            'index' => 'post/index',
            'help' => 'index',
            'devHelp' => 'help',
            'status' => 'index',
            'options' => 'index',
        );
    }

    /**
     * {@inheritdoc}
     *
     * @return array Set of actions navigation links definitions.
     * @since 0.1.0
     */
    public function navigationLinks()
    {
        return array(
            'help' => array('index',),
            'devHelp' => array('index', 'help',),
            'status' => array('options', 'index',),
        );
    }
}
