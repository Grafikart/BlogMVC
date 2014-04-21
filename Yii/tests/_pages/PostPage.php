<?php

/**
 * This class represents single publication page.
 *
 * @version    Release: 0.1.0
 * @since      0.1.0
 * @package    BlogMVC
 * @subpackage YiiTests
 * @author     Fike Etki <etki@etki.name>
 */
class PostPage
{
    /**
     * Post page url pattern.
     *
     * @var string
     * @since 0.1.0
     */
    public static $url = '/<slug>';
    /**
     * Yii controller rout for post page.
     *
     * @var string
     * @since 0.1.0
     */
    public static $route = 'post/show';
    /**
     * Comment form selector.
     *
     * @var string
     * @since 0.1.0
     */
    public static $commentForm = '';
    /**
     * Comment username field name.
     *
     * @var string
     * @since 0.1.0
     */
    public static $commentUsernameField = '';
    /**
     * Comment email field name.
     *
     * @var string
     * @since 0.1.0
     */
    public static $commentEmailField = '';
    /**
     * Comment text field name.
     *
     * @var string
     * @since 0.1.0
     */
    public static $commentTextArea = '';
    /**
     * Comment publication button selector.
     *
     * @var string
     * @since 0.1.0
     */
    public static $commentSubmitButton = '';

    /**
     * Returns url for particular post by it's slug.
     *
     * @param string $slug Post slug.
     *
     * @return mixed
     * @since 0.1.0
     */
    public static function route($slug)
    {
        return str_replace('<slug>', $slug, static::$url);
    }
}