<?php

/**
 * Represents admin index page.
 *
 * @version    Release: 0.1.0
 * @since      0.1.0
 * @package    BlogMVC
 * @subpackage YiiTests
 * @author     Fike Etki <etki@etki.name>
 */
class AdminPanelPage extends \GeneralPage
{
    /**
     * Page URL.
     *
     * @var string
     * @since 0.1.0
     */
    public static $url = '/admin';
    /**
     * Yii controller route.
     *
     * @type string
     * @since 0.1.0
     */
    public static $route = 'admin/index';
    /**
     * CSS selector for posts dashboard link.
     *
     * @type string
     * @since 0.1.0
     */
    public static $postsDashboardLink = '.container:nth-child(2) .row a';
    /**
     * Posts dashboard link text.
     *
     * @type string
     * @since 0.1.0
     */
    public static $postsDashboardLinkText = 'posts dashboard';
    /**
     * Users dashboard link CSS selector.
     *
     * @type string
     * @since 0.1.0
     */
    public static $usersDashboardLink = '.container:nth-child(4) .row:first-child a';
    /**
     * Users dashboard link text.
     *
     * @type string
     * @since 0.1.0
     */
    public static $usersDashboardLinkText = 'here';
    /**
     * Profile link CSS selector.
     *
     * @type string
     * @since 0.1.0
     */
    public static $profileLink = '.container:nth-child(4) .row:nth-child(2) a';
    /**
     * Profile link text.
     *
     * @type string
     * @since 0.1.0
     */
    public static $profileLinkText = 'link';
    /**
     * Service options link selector.
     *
     * @type string
     * @since 0.1.0
     */
    public static $serviceOptionsLink = '.container:nth-child(4) .row:nth-child(3) a';
    /**
     * Service options link text.
     *
     * @type string
     * @since 0.1.0
     */
    public static $serviceOptionsLinkText = 'here';
    /**
     * Help link selector.
     *
     * @type string
     * @since 0.1.0
     */
    public static $helpLink = '.container:nth-child(6) a';
    /**
     * Help link text.
     *
     * @type string
     * @since 0.1.0
     */
    public static $helpLinkText = 'here';
}