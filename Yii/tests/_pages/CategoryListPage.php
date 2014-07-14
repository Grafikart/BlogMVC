<?php

/**
 * This class represents public category listing page.
 *
 * @version    0.1.0
 * @since      0.1.0
 * @package    BlogMVC
 * @subpackage YiiTests
 * @author     Fike Etki <etki@etki.name>
 */
class CategoryListPage extends \GeneralPage
{
    /**
     * Page URL.
     *
     * @type string
     * @since 0.1.0
     */
    public static $url = '/category';
    /**
     * Internal Yii page route.
     *
     * @type string
     * @since 0.1.0
     */
    public static $route = 'category/list/type/public';
}