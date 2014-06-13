<?php

/**
 * This class represents blog feed of a single author.
 *
 * @version    Release: 0.1.0
 * @since      0.1.0
 * @package    BlogMVC
 * @subpackage YiiTests
 * @author     Fike Etki <etki@etki.name>
 */
class AuthorFeedPage extends \FeedPage
{
    /**
     * Url template.
     *
     * @type string
     * @since 0.1.0
     */
    static $url = '/author/<id>';
    /**
     * Yii internal controller route for author pages.
     *
     * @type string
     * @since 0.1.0
     */
    static $route = 'author/index';
    /**
     * 'Back to main feed' link selector.
     *
     * @type string
     * @since 0.1.0
     */
    static $backToMainFeedLink = '.page-header a';

    /**
     * Returns page url for particular author.
     *
     * @param string|int      $id   Author ID.
     * @param string|int|null $page Page number.
     *
     * @return string Page URL.
     * @since 0.1.0
     */
    public static function route($id, $page=null)
    {
        return parent::route('<id>', $id, $page);
    }
}