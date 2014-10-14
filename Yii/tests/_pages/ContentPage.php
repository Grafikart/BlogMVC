<?php

/**
 * This class encapsulates shared functionality for content pages: single post
 * pages and various post feeds.
 *
 * @todo move sidebar-related stuff from feed page here
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
    /**
     * CSS selector for sidebar block.
     *
     * @type string
     * @since 0.1.0
     */
    public static $sidebarSelector = '.sidebar';
    /**
     * CSS selector for categories list block in sidebar.
     *
     * @type string
     * @since 0.1.0
     */
    public static $sidebarCategoryListSelector
        = '.sidebar .list-group.categories';
    /**
     * CSS selector for posts list block in sidebar.
     *
     * @type string
     * @since 0.1.0
     */
    public static $sidebarPostListSelector = '.sidebar .list-group.posts';
    /**
     * CSS selector for post block. Useful to fetch ID without explicit
     * selecting 'article', for example.
     *
     * @type string
     * @since 0.1.0
     */
    public static $postSelector = 'article';
}
 