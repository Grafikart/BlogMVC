<?php

/**
 * Displays category feeds, listings and manages category list.
 *
 * @version    Release: 0.1.0
 * @since      0.1.0
 * @package    BlogMVC
 * @subpackage Yii
 * @author     Fike Etki <etki@etki.name>
 */
class CategoryController extends \BaseController
{
    /**
     * Main action that displays category page.
     *
     * @param string $slug Category slug.
     *
     * @throws \EHttpException HTTP error 404 is generated if requested page
     * doesn't exist.
     *
     * @return void
     * @since 0.1.0
     */
    public function actionIndex($slug)
    {
        $category = \Category::model()->findBySlug($slug);
        if (!$category || !$category->post_count) {
            throw new \EHttpException(404);
        }
        // if post_count is correct, there is more than zero posts to show and
        // following statement will cause no error
        // if post_count is incorrect, i'm deeply tucked even before this line
        $category->posts = \Post::model()
            ->paged($this->page->pageNumber, 5)
            ->findByCategory($category->id);
        $this->page->totalPages = ceil($category->post_count / 5);
        $this->page->resetI18n(array('{categoryTitle}' => $category->name));
        $data = array('category' => $category, 'posts' => $category->posts);
        $this->render('index', $data, $category);
    }

    /**
     * Lists page (10 records) of available categories.
     *
     * @throws \EHttpException HTTP error 400 is generated if invalid page
     * number is supplied.
     *
     * @return void
     * @since 0.1.0
     */
    public function actionList()
    {
        $categories = \Category::model()
            ->paged($this->page->pageNumber, 10)
            ->findAll();
        if (empty($categories) && $this->page->pageNumber > 1) {
            throw new \EHttpException(404);
        }
        $this->page->totalPages = ceil(\Category::model()->count() / 10);
        $this->render('list', array('categories' => $categories,));
    }

    /**
     * Displays category dashboard.
     *
     * @throws EHttpException HTTP error 404 is thrown if requested page doesn't
     *                        exist.
     *
     * @todo 95% of code is simply identical to actionList(). Any chance to
     * merge it without breaking access rules and minds?
     *
     * @return void
     * @since 0.1.0
     */
    public function actionDashboard()
    {
        $categories = \Category::model()
            ->paged($this->page->pageNumber, 10)
            ->findAll();
        if (empty($categories) && $this->page->pageNumber > 1) {
            throw new \EHttpException(404);
        }
        $this->page->totalPages = ceil(\Category::model()->count() / 10);
        $this->render('dashboard', array('categories' => $categories,));
    }

    /**
     * Renders category form for new or existing category.
     *
     * @param null|string|int $slug Category slug.
     *
     * @throws \EHttpException Thrown if category for specified ID doesn't
     *                         exist.
     *
     * @return void
     * @since 0.1.0
     */
    public function actionEdit($slug=null)
    {
        if (!($category = \Category::model()->findBySlugOrCreate($slug))) {
            throw new \EHttpException(404);
        }
        if ($data = \Yii::app()->user->getData('category')) {
            $category->setAndValidate($data);
        }
        if ($slug) {
            $this->page->resetI18n(array('{categoryTitle}' => $category->name));
        } else {
            $this->page->resetI18n(array(), 'pageTitle.category.new');
        }
        $this->render('form', array('category' => $category));
    }

    /**
     * Saves new/existing model via AJAX call.
     *
     * @param null|string|int $slug Category slug.
     *
     * @throws \EHttpException Thrown if accessed non-ajaxly, no data sent or
     * model with specified ID doesn't exist.
     *
     * @todo update render method(s) to avoid lines of code like the last ones
     *
     * @return void
     * @since 0.1.0
     */
    public function actionAjaxSave()
    {
        if (\Yii::app()->request->isAjaxRequest
            && (!defined('YII_DEBUG') || !YII_DEBUG)
        ) {
            throw new \EHttpException(400, 'badRequest.ajaxOnly');
        }
        if (!($data = \Yii::app()->request->getPost('Category'))) {
            throw new \EHttpException(400, 'badRequest.noDataReceived');
        }
        if (isset($data['id'])) {
            if (!($category = \Category::model()->findByPk($data['id']))) {
                throw new \EHttpException(404);
            }
        } else {
            $category = new \Category;
        }
        $response = array(
            'success' => true,
        );
        if (!$category->setAndSave($data)) {
            $response['success'] = false;
            $response['errors'] = $category->getErrors();
        } else {
            $response['data'] = $category->getPublicAttributes();
        }
        $this->page->format = 'json';
        header($this->page->generateFormatHeader());
        echo \CJSON::encode($response);
    }

    /**
     * Adds new record or bounces back errors.
     *
     * @param int|string|null $slug Category slug.
     *
     * @throws \EHttpException Thrown if no data received or category doesn't
     * exist.
     *
     * @return void
     * @since 0.1.0
     */
    public function actionSave($slug=null)
    {
        if (!($data = \Yii::app()->request->getPost('Category'))) {
            throw new \EHttpException(400, 'badRequest.noDataReceived');
        }
        if (!($category = \Category::model()->findBySlugOrCreate($slug))) {
            throw new \EHttpException(404);
        }
        $prefix = 'category.'.($category->isNewRecord?'submit':'update').'.';
        $i18nData = array('{category}' => $category->name);
        if ($category->setAndSave($data)) {
            $i18nData['{category}'] = $category->name;
            \Yii::app()->user->sendSuccessMessage($prefix.'success', $i18nData);
            $this->redirect(array('category/dashboard'));
        } else {
            \Yii::app()->user->saveData('category', $data);
            \Yii::app()->user->sendErrorMessage($prefix.'fail', $i18nData);
            $data = array('category/edit');
            if ($slug) {
                $data['slug'] = $slug;
            }
            $this->redirect($data);
        }
    }

    /**
     * Deletes category.
     *
     * @param string $slug Category slug.
     *
     * @throws \EHttpException Thrown if category doesn't exist (404).
     * @throws \EHttpException Thrown if category is not empty (403).
     *
     * @return void
     * @since 0.1.0
     */
    public function actionDelete($slug)
    {
        $category = \Category::model()->findBySlug($slug);
        if (!$category) {
            throw new \EHttpException(404);
        }
        $data = array('{categoryTitle}' => $category->name,);
        if ($category->post_count != 0) {
            $key = 'badRequest.categoryNotEmpty';
            throw new \EHttpException(400, $key, $data);
        } else if ($category->delete()) {
            $key = 'category.delete.success';
            \Yii::app()->user->sendSuccessMessage($key, $data);
        } else {
            \Yii::app()->user->sendErrorMessage('category.delete.fail', $data);
        }
        $this->redirect(array('dashboard'));
    }

    /**
     * Defines controller filters.
     *
     * @return array List of filters.
     * @since 0.1.0
     */
    public function filters()
    {
        return array('accessControl');
    }

    /**
     * Defines access rules for actions.
     *
     * @return array Set of rules.
     * @since 0.1.0
     */
    public function accessRules()
    {
        return array(
            array(
                'deny',
                'actions' => array(
                    'recalculate',
                    'ajaxAdd',
                    'add',
                    'dashboard',
                    'edit',
                ),
                'users' => array('?')
            ),
            array('allow'),
        );
    }

    /**
     * {@inheritdoc}
     *
     * @return string[] List of action parent actions.
     * @since 0.1.0
     */
    public function getActionAncestors()
    {
        return array(
            'index' => 'list',
            'list' => 'post/index',
            'dashboard' => 'admin/index',
            'edit' => 'dashboard'
        );
    }

    /**
     * {@inheritdoc}
     *
     * @return array Navigation links definitions.
     * @since 0.1.0
     */
    public function navigationLinks()
    {
        return array(
            'index' => array('post/index', 'list',),
            'edit' => array('dashboard',),
            'dashboard' => array(
                array(
                    'route' => 'edit',
                    'type' => 'button',
                    'title' => 'control.addNew',
                ),
            )
        );
    }
}
