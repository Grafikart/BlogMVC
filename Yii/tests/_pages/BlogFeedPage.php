<?php

/**
 * Represents main feed page.
 *
 * @version    Release: 0.1.0
 * @since      0.1.0
 * @package    BlogMVC
 * @subpackage YiiTests
 * @author     Fike Etki <etki@etki.name>
 */
class BlogFeedPage
{
    /**
     * Page url.
     *
     * @type string
     * @since 0.1.0
     */
    public static $url = '/';
    /**
     * Yii internal controller page route.
     *
     * @type string
     * @since 0.1.0
     */
    public static $route = 'post/index';

    /**
     * Returns url for specified page.
     *
     * @param int|string $page Page number.
     *
     * @return string
     * @since 0.1.0
     */
    public static function route($page)
    {
        return static::$url.'?page='.$page;
    }
}