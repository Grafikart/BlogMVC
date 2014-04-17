<?php

/**
 * This controller holds single action for displaying category posts.
 *
 * @author Fike Etki <etki@etki.name>
 * @version 0.1.0
 * @since 0.1.0
 * @package blogmvc
 * @subpackage yii
 */
class CategoryController extends BaseController
{
    /**
     * Alters breadcrumb array by adding proper name to the last element
     * 
     * @param \Category $category current category.
     * @return void
     * @since 0.1.0
     */
    public function alterBreadcrumbs($lastPageName) {
        $this->breadcrumbs[sizeof($this->breadcrumbs) - 1]['title'] = $lastPageName;
    }
    /**
     * Main action that displays category page.
     * 
     * @throws \HttpException HTTP error 400 is generated if incorrect page
     * is requested.
     * @throws \HttpException HTTP error 404 is generated if requested page
     * doesn't exist.
     * 
     * @param string $slug Category slug.
     * @param int|string $page Page number.
     * @return void
     * @since 0.1.0
     */
    public function actionIndex($slug, $page=1)
    {
        $page = $this->setPageNumber($page);
        $category = Category::model()->paged($page, 5)->with(array( // note that paged scope is applied on Category :/
            'posts' => array(
                //'scopes' => array('paged' => $page,),
            ),
            'postCount',
        ))->find('t.slug = :slug', array(':slug' => $slug));
        if ($category === null || sizeof($category->posts) === 0) {
            throw new \HttpException(404);
        }
        $this->addBreadcrumbsReplacement($category->slug, $category->name);
        $this->generateBreadcrumbs();
        $this->render('index', array(
            'category' => $category,
            'pagination' => array(
                'currentPage' => $page,
                'totalPages' => ceil((int) $category->postCount / 5),
                'route' => 'category/index',
                'routeOptions' => array('slug' => $slug),
            ),
        ));
    }
    /**
     * Lists page (25 records) of available categories.
     * 
     * @throws \HttpException HTTP error 400 is generated if invalid page
     * number is supplied.
     * 
     * @param int $page Page number
     * @since 0.1.0
     */
    public function actionList($page=1)
    {
        if (($page = (int) $page) < 1) {
            throw new \HttpException(400, 'badRequest.invalidPage');
        }
        $this->alterBreadcrumbs(Yii::t('templates', 'category.listTitle'));
        $categories = Category::model()->paged($page, 25)->findAll();
        $totalPages = ceil(Category::model()->count()/25);
        $this->render('listing', array(
            'categories' => $categories,
            'pagination' => array(
                'currentPage' => $page,
                'totalPages' => $totalPages,
                'route' => 'category/index',
            ),
        ));
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
            array('deny', 'actions' => array('recalculate'), 'users' => array('?')),
            array('allow'),
        );
    }
}
