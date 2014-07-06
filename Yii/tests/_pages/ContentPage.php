<?php

/**
 * 
 *
 * @version Release: 0.1.0
 * @since   
 * @package _pages
 * @author  Fike Etki <etki@etki.name>
 */
class ContentPage extends \GeneralPage
{
    /**
     * CSS selector for user link in post.
     *
     * @type string
     * @since 0.1.1
     */
    public static $postUserLinkSelector = 'article a[role="user-link"]';
    /**
     * CSS selector for post title.
     *
     * @type string
     * @since 0.1.0
     */
    public static $postTitleSelector = 'article h2 a';
    /**
     * CSS selector for category link in post.
     *
     * @type string
     * @since 0.1.0
     */
    public static $postCategoryLinkSelector = 'article a[role="category-link"]';
}
 