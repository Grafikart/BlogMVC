<?php

/**
 * Represents one of the feed pages: index (main blog feed), category and author
 * feed.
 *
 * @version    Release: 0.1.0
 * @since      0.1.0
 * @package    BlogMVC
 * @subpackage YiiTests
 * @author     Fike Etki <etki@etki.name>
 */
class FeedPage
{
    /**
     * Page url for main blog feed.
     *
     * @var string
     * @since 0.1.0
     */
    public static $blogPageUrl = '/';
    /**
     * Yii internal route for standard utility feed.
     *
     * @var string
     * @since 0.1.0
     */
    public static $blogPageRoute = 'post/index';
    /**
     * Category page base url.
     *
     * @var string
     * @since 0.1.0
     */
    public static $categoryPageUrl = '/category/<slug>';
    /**
     * Yii internal route for particular category feed.
     *
     * @var string
     * @since 0.1.0
     */
    public static $categoryPageRoute = 'category/index';
    /**
     * Author page base url.
     *
     * @var string
     * @since 0.1.0
     */
    public static $authorPageUrl = '/author/<id>';
    /**
     * Yii internal route for particular author feed.
     *
     * @var string
     * @since 0.1.0
     */
    public static $authorPageRoute = 'author/index';

    /**
     * Creates url for particular category feed.
     *
     * @param string $slug Category slug.
     * @param int    $page Page number.
     *
     * @return mixed
     * @since 0.1.0
     */
    public static function categoryRoute($slug, $page=1)
    {
        $url = str_replace('<slug>', $slug, static::$categoryPageUrl);
        if ($page !== 1) {
            $url .= '?page='.$page;
        }
        return $url;
    }

    /**
     * Creates url for particular author feed.
     *
     * @param string $id   Author id.
     * @param int    $page Page number.
     *
     * @return mixed
     * @since 0.1.0
     */
    public static function authorRoute($id, $page=1)
    {
        $url = str_replace('<id>', $id, static::$authorPageUrl);
        if ($page !== 1) {
            $url .= '?page='.$page;
        }
        return $url;
    }
}