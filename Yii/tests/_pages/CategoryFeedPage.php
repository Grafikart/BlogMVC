<?php

/**
 * This class represents category feed page.
 *
 * @version    Release: 0.1.0
 * @since      0.1.0
 * @package    BlogMVC
 * @subpackage YiiTests
 * @author     Fike Etki <etki@etki.name>
 */
class CategoryFeedPage extends \FeedPage
{
    /**
     * Category page url template.
     *
     * @type string
     * @since 0.1.0
     */
    public static $url = '/category/<slug>';
    /**
     * Yii controller route for category page.
     *
     * @type string
     * @since 0.1.0
     */
    public static $route = 'category/index';
    /**
     * CSS selector for 'Back to main feed' link.
     *
     * @type string
     * @since 0.1.0
     */
    public static $backToMainFeedLink = '.page-header a';

    /**
     * Returns route to particular category.
     *
     * @param string $slug Category slug.
     *
     * @return string Page url.
     * @since 0.1.0
     */
    public static function route($slug)
    {
        return str_replace('<slug>', $slug, static::$url);
    }
}