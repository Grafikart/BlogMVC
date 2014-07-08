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
    public static $editPostButtonSelector = '[role="edit-post-link"]';
    /**
     * `Delete post` button selector. Note that it matches all `Delete post`
     * buttons on page.
     *
     * @var string
     * @since 0.1.0
     */
    public static $deletePostButtonSelector = '[role="delete-post-link"]';
    /**
     * CSS selector template for selecting single row for particular post.
     *
     * @type string
     * @since 0.1.0
     */
    public static $postRowSelectorTemplate = '#post-<id>';

    /**
     * Creates CSS selector for delete button for post with particular id.
     *
     * @param int|string $postId ID of post selector is created for.
     *
     * @return string CSS selector matching particular post delete button.
     * @since 0.1.0
     */
    public static function getPostDeleteButtonSelector($postId)
    {
        $row = str_replace('<id>', $postId, static::$postRowSelectorTemplate);
        return $row.' '.static::$deletePostButtonSelector;
    }

    /**
     * Creates CSS selector for edit button for post with particular id.
     *
     * @param int|string $postId ID of post selector is created for.
     *
     * @return string CSS selector matching particular post edit button.
     * @since 0.1.0
     */
    public static function getPostEditButtonSelector($postId)
    {
        $row = str_replace('<id>', $postId, static::$postRowSelectorTemplate);
        return $row.' '.static::$editPostButtonSelector;
    }

    /**
     * Clicks delete button for particular post.
     *
     * @param int|string $postId ID of post button is bound to.
     *
     * @return void
     * @since 0.1.0
     */
    public function clickDeletePostButton($postId)
    {
        $this->guy->click(static::getPostDeleteButtonSelector($postId));
    }

    /**
     * Clicks edit button for particular post.
     *
     * @param int|string $postId ID of post button is bound to.
     *
     * @return void
     * @since 0.1.0
     */
    public function clickEditPostButton($postId)
    {
        $this->guy->click(static::getPostEditButtonSelector($postId));
    }
}