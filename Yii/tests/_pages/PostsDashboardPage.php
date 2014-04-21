<?php

/**
 * This class represents posts dashboard page, all of it's button, pixels and
 * boredom.
 *
 * @version    Release: 0.1.0
 * @since      0.1.0
 * @package    BlogMVC
 * @subpackage YiiTests
 * @author     Fike Etki <etki@etki.name>
 */
class PostsDashboardPage extends \GeneralPage
{
    /**
     * Post dashboard page url.
     *
     * @var string
     * @since 0.1.0
     */
    public static $url = '/admin/posts';
    /**
     * Yii controller route for posts dashboard page
     *
     * @var string
     * @since 0.1.0
     */
    public static $route = 'admin/posts';
    /**'
     * `Create new post` button selector.
     *
     * @var string
     * @since 0.1.0
     */
    public static $newPostButton = '[role="create-post-link"]';
    /**
     * `Edit post` button selector. Note that it matches all `Edit post`
     * buttons on page.
     *
     * @var string
     * @since 0.1.0
     */
    public static $editPostButton = '[role="edit-post-link"]';
    /**
     * `Delete post` button selector. Note that it matches all `Delete post`
     * buttons on page.
     *
     * @var string
     * @since 0.1.0
     */
    public static $deletePostButton = '[role="delete-post-link"]';
}